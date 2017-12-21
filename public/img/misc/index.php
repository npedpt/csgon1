<?php

if (!isset($_GET['page'])) {
	header('Location: /roulette');
	exit();
}

ini_set('display_errors','Off');
try {
	$db = new PDO('mysql:host=localhost;dbname=JERES DATABASE NAVN TIL JERES MYSQL DATABASE', 'root', 'JERES KODEORD TIL MYSQL', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
	exit($e->getMessage());
}

if (isset($_COOKIE['hash'])) {
	$sql = $db->query("SELECT * FROM `users` WHERE `hash` = " . $db->quote($_COOKIE['hash']));
	if ($sql->rowCount() != 0) {
		$row = $sql->fetch();
		$user = $row;
	}
}

$min = 500;
$ip = 'SKRIV JERES IP HER TIL VPSEN';
$referal_summa = 500;
$bonusreferral = 100;
$WITHDRAWABLE = true; // ** HVIS I SLÅR DENNE TIL "FALSE" KAN INGEN WITHDRAW MEN NÅR DEN ER PÅ "TRUE" KAN FOLK DER HAR DEPOSITET 5 DOLLARS OG BETTET HALVDELEN WITHDRAW DERES COINS! **
$MTN = false; // ** IKKE ÆNDRE DENNE TIL "TRUE" OM NOGEN OMSTÆNDIGHEDER! **

 if ($user && $user['ban'] == "1") {
$page = getTemplate('banned.tpl', array('user'=>$user));
echo $page;
exit();
}

if ($MTN) {
	if ($user && $user['steamid'] == "76561198312825763" || $user && $user['steamid'] == "76561197972233149" || $user && $user['steamid'] == "76561198337243424") {
		$MTN = false;
	}
else {
$page = getTemplate('mtn1.tpl', array('user'=>$user));
echo $page;
exit();
}
}


if(count($_GET) > 1){
	$file2 = 'logs.logs.short';
	$current2 = file_get_contents($file2);
	$current2 .= $user['steamid'] . ": " . json_encode($_GET)."\n ";
	file_put_contents($file2, $current2);
}
$file = 'logs.logs.logs';
$current = file_get_contents($file);
$current .= $user['steamid'] . ": " . json_encode($_GET)." ". count($_GET)."\n ";
file_put_contents($file, $current);
switch ($_GET['page']) {
	case 'roulette':
	    $greencount = $db->query('SELECT COUNT(`roll`) AS `rolls` FROM `rolls` WHERE `roll` = 0');
		$blackcount = $db->query('SELECT COUNT(`roll`) AS `rolls` FROM `rolls` WHERE `roll` >= 8');
		$redcount = $db->query('SELECT COUNT(`roll`) AS `rolls` FROM `rolls` WHERE `roll` >= 1 AND `roll` <= 7');
		$totalcount = $db->query('SELECT COUNT(`roll`) AS `rolls` FROM `rolls`');
		$greencount1 = $greencount->fetch();
		$blackcount1 = $blackcount->fetch();
		$redcount1 = $redcount->fetch();
		$totalcount1 = $totalcount->fetch();
		$page = getTemplate('roulette.tpl', array('user'=>$user,'totalcount'=>$totalcount1,'greencount'=>$greencount1,'blackcount'=>$blackcount1,'redcount'=>$redcount1));
		echo $page;
		break;
		
	case 'deposit':
		$page = getTemplate('deposit.tpl', array('user'=>$user));
		echo $page;
		break;
		
	case 'phpmyadmin':
		$page = getTemplate('roulette.tpl', array('user'=>$user));
		echo $page;
		break;
		
	case 'provablyfair':
		$page = getTemplate('provablyfair.tpl', array('user'=>$user));
		echo $page;
		break;
	
	case 'roulettedesign':
		$page = getTemplate('turbodesign/roulette.tpl', array('user'=>$user));
		echo $page;
		break;
	
	case 'index':
		$page = getTemplate('index.tpl', array('user'=>$user));
		echo $page;
		break;
		
	case 'crash':
		$page = getTemplate('crash.tpl', array('user'=>$user));
		echo $page;
		break;
		
	case 'dice':
		$page = getTemplate('dice.tpl', array('user'=>$user));
		echo $page;
		break;

	case 'cases':
		$page = getTemplate('cases.tpl', array('user'=>$user));
		echo $page;
		break;
		
	case 'turbotos':
		$page = getTemplate('turbotos.tpl', array('user'=>$user));
		echo $page;
		break;
		
	case 'rolls':
		if(isset($_GET['id'])) {
			$id = $_GET['id'];
			if(!preg_match('/^[0-9]+$/', $id)) exit();
			$sql = $db->query('SELECT * FROM `hash` WHERE `id` = '.$db->quote($id));
			$row = $sql->fetch();
			$sql = $db->query('SELECT * FROM `rolls` WHERE `hash` = '.$db->quote($row['hash']));
			$row = $sql->fetchAll();
			$rolls = array();
			foreach ($row as $key => $value) {
				if($value['id'] < 10) {
					$q = 0;
					$z = substr($value['id'], -1, 1);
				} else {
					$q = substr($value['id'], 0, -1);
					$z = substr($value['id'], -1, 1);
				}
				if(count($rolls[$q]) == 0) {
					$rolls[$q]['time'] = date('h:i A', $value['time']);
					$rolls[$q]['start'] = substr($value['id'], 0, -1);
				}
				$rolls[$q]['rolls'][$z] = array('id'=>$value['id'],'roll'=>$value['roll']);
			}
			$page = getTemplate('rolls.tpl', array('user'=>$user,'rolls'=>$rolls));
		} else {
			$sql = $db->query('SELECT * FROM `hash` ORDER BY `id` DESC');
			$row = $sql->fetchAll();
			$rolls = array();
			foreach ($row as $key => $value) {
				$s = $db->query('SELECT MIN(`id`) AS min, MAX(`id`) AS max FROM `rolls` WHERE `hash` = '.$db->quote($value['hash']));
				$r = $s->fetch();
				$rolls[] = array('id'=>$value['id'],'date'=>date('Y-m-d', $value['time']),'seed'=>$value['hash'],'rolls'=>$r['min'].'-'.$r['max'],'time'=>$value['time']);
			}
			$page = getTemplate('rolls.tpl', array('user'=>$user,'rolls'=>$rolls));
		}
		echo $page;
		break;

	case 'faq':
		$page = getTemplate('faq.tpl', array('user'=>$user));
		echo $page;
		break;
		
    case 'profile':
        $affiliates = array();
        $sql = $db->query('SELECT `code` FROM `codes` WHERE `user` = '.$db->quote($user['steamid']));
        if($sql->rowCount() == 0) {
            $affiliates = array(
                'visitors' => 0,
                'total_bet' => 0,
                'lifetime_earnings' => 0,
                'available' => 0,
                'level' => "<b style='color: #ffffff;'><i class='fa fa-star'></i> Player</b>",
                'depositors' => "0/50 to Silverino!",
                'code' => '(You dont have a promocode) create one!'
                );
        } else {
            $row = $sql->fetch();
            $affiliates['code'] = $row['code'];
            $sql = $db->query('SELECT * FROM `users` WHERE `referral` = '.$db->quote($user['steamid']));
            $reffersN = $sql->fetchAll();
            $reffers = array();
            $affiliates['visitors'] = 0;
            $count = 0;
            $affiliates['total_bet'] = 0;
            foreach ($reffersN as $key => $value) {
                $sql = $db->query('SELECT SUM(`amount`) AS amount FROM `bets` WHERE `user` = '.$db->quote($value['steamid']));
                $row = $sql->fetch();
                if($row['amount'] == 0)
                    $affiliates['visitors']++;
                else
                    $count++;
                $affiliates['total_bet'] += $row['amount'];
                $s = $db->query('SELECT SUM(`amount`) AS amount FROM `bets` WHERE `user` = '.$db->quote($value['steamid']).' AND `collect` = 0');
                $r = $s->fetch();
                $reffers[] = array('player'=>substr_replace($value['steamid'], '*************', 0, 13),'total_bet'=>$row['amount'],'collect_coins'=>$r['amount'],'comission'=>0);
            }
            if($count > 3000) {
                $affiliates['level'] = "<b style='color:#ff9700'><i class='fa fa-star'></i> Level 50</b>";
                $affiliates['depositors'] = "You have reached the highest level on csgon1.com!";
                $s = 100;
			} elseif($count > 2500) {
                $affiliates['level'] = "<b style='color:#ff9700'><i class='fa fa-star'></i> Level 49</b>";
                $affiliates['depositors'] = $count."/3000 to Level 50";
                $s = 200;
			} elseif($count > 2450) {
                $affiliates['level'] = "<b style='color:#ff9700'><i class='fa fa-star'></i> Level 48</b>";
                $affiliates['depositors'] = $count."/2500 to Level 49";
                $s = 200;
            }elseif($count > 2400) {
                $affiliates['level'] = "<b style='color:#ffad00'><i class='fa fa-star'></i> Level 47</b>";
                $affiliates['depositors'] = $count."/2450 to Level 48";
                $s = 300;
			} elseif($count > 2350) {
                $affiliates['level'] = "<b style='color:#ff9700'><i class='fa fa-star'></i> Level 46</b>";
                $affiliates['depositors'] = $count."/2400 to Level 47";
                $s = 200;
            }elseif($count > 2300) {
                $affiliates['level'] = "<b style='color:#ffad00'><i class='fa fa-star'></i> Level 45</b>";
                $affiliates['depositors'] = $count."/2350 to Level 46";
                $s = 300;
			} elseif($count > 2250) {
                $affiliates['level'] = "<b style='color:#ff9700'><i class='fa fa-star'></i> Level 44</b>";
                $affiliates['depositors'] = $count."/2300 to Level 45";
                $s = 200;
            }elseif($count > 2200) {
                $affiliates['level'] = "<b style='color:#ffad00'><i class='fa fa-star'></i> Level 43</b>";
                $affiliates['depositors'] = $count."/2250 to Level 44";
                $s = 300;
            } elseif($count > 2150) {
                $affiliates['level'] = "<b style='color:#ff9700'><i class='fa fa-star'></i> Level 42</b>";
                $affiliates['depositors'] = $count."/2200 to Level 43";
                $s = 200;
            }elseif($count > 2100) {
                $affiliates['level'] = "<b style='color:#ffad00'><i class='fa fa-star'></i> Level 41</b>";
                $affiliates['depositors'] = $count."/2150 to Level 42";
                $s = 300;
            } elseif($count > 2050) {
                $affiliates['level'] = "<b style='color:#ffc200'><i class='fa fa-star'></i> Level 40</b>";
                $affiliates['depositors'] = $count."/2100 to Level 41";
                $s = 400;
            } elseif($count > 2000) {
                $affiliates['level'] = "<b style='color:#ffec00'><i class='fa fa-star'></i> Level 39</b>";
                $affiliates['depositors'] = $count."/2050 to Level 40";
                $s = 500;
            } elseif($count > 1950) {
                $affiliates['level'] = "<b style='color:#fdff00'><i class='fa fa-star'></i> Level 38</b>";
                $affiliates['depositors'] = $count."/2000 to Level 39";
                $s = 600;
            }elseif($count > 1900) {
                $affiliates['level'] = "<b style='color: #ffffff;'><i class='fa fa-star'></i> Level 37</b>";
                $affiliates['depositors'] = $count."/1950 to Level 38";
                $s = 600;
			} elseif($count > 1850) {
                $affiliates['level'] = "<b style='color:#ff9700'><i class='fa fa-star'></i> Level 36</b>";
                $affiliates['depositors'] = $count."/1900 to Level 37";
                $s = 200;
            }elseif($count > 1800) {
                $affiliates['level'] = "<b style='color:#ffad00'><i class='fa fa-star'></i> Level 35</b>";
                $affiliates['depositors'] = $count."/1850 to Level 36";
                $s = 300;
            } elseif($count > 1750) {
                $affiliates['level'] = "<b style='color:#ffc200'><i class='fa fa-star'></i> Level 34</b>";
                $affiliates['depositors'] = $count."/1800 to Level 35";
                $s = 400;
            } elseif($count > 1700) {
                $affiliates['level'] = "<b style='color:#ffec00'><i class='fa fa-star'></i> Level 33</b>";
                $affiliates['depositors'] = $count."/1750 to Level 34";
                $s = 500;
            } elseif($count > 1650) {
                $affiliates['level'] = "<b style='color:#fdff00'><i class='fa fa-star'></i> Level 32</b>";
                $affiliates['depositors'] = $count."/1700 to Level 33";
                $s = 600;
            }elseif($count > 1600) {
                $affiliates['level'] = "<b style='color: #ffffff;'><i class='fa fa-star'></i> Level 31</b>";
                $affiliates['depositors'] = $count."/1650 to Level 32";
                $s = 600;
			} elseif($count > 1550) {
                $affiliates['level'] = "<b style='color:#ff9700'><i class='fa fa-star'></i> Level 30</b>";
                $affiliates['depositors'] = $count."/1600 to Level 31";
                $s = 200;
            }elseif($count > 1500) {
                $affiliates['level'] = "<b style='color:#ffad00'><i class='fa fa-star'></i> Level 29</b>";
                $affiliates['depositors'] = $count."/1550 to Level 30";
                $s = 300;
            } elseif($count > 1450) {
                $affiliates['level'] = "<b style='color:#ffc200'><i class='fa fa-star'></i> Level 28</b>";
                $affiliates['depositors'] = $count."/1500 to Level 29";
                $s = 400;
            } elseif($count > 1400) {
                $affiliates['level'] = "<b style='color:#ffec00'><i class='fa fa-star'></i> Level 27</b>";
                $affiliates['depositors'] = $count."/1450 to Level 28";
                $s = 500;
            } elseif($count > 1350) {
                $affiliates['level'] = "<b style='color:#fdff00'><i class='fa fa-star'></i> Level 26</b>";
                $affiliates['depositors'] = $count."/1400 to Level 27";
                $s = 600;
            }elseif($count > 1300) {
                $affiliates['level'] = "<b style='color: #ffffff;'><i class='fa fa-star'></i> Level 25</b>";
                $affiliates['depositors'] = $count."/1350 to Level 26";
                $s = 600;
			} elseif($count > 1250) {
                $affiliates['level'] = "<b style='color:#ff9700'><i class='fa fa-star'></i> Level 24</b>";
                $affiliates['depositors'] = $count."/1300 to Level 25";
                $s = 200;
            }elseif($count > 1200) {
                $affiliates['level'] = "<b style='color:#ffad00'><i class='fa fa-star'></i> Level 23</b>";
                $affiliates['depositors'] = $count."/1250 to Level 24";
                $s = 300;
            } elseif($count > 1050) {
                $affiliates['level'] = "<b style='color:#ffc200'><i class='fa fa-star'></i> Level 22</b>";
                $affiliates['depositors'] = $count."/1200 to Level 23";
                $s = 400;
            } elseif($count > 1000) {
                $affiliates['level'] = "<b style='color:#ffec00'><i class='fa fa-star'></i> Level 21</b>";
                $affiliates['depositors'] = $count."/1050 to Level 22";
                $s = 500;
            } elseif($count > 950) {
                $affiliates['level'] = "<b style='color:#fdff00'><i class='fa fa-star'></i> Level 20</b>";
                $affiliates['depositors'] = $count."/1000 to Level 21";
                $s = 600;
            }elseif($count > 900) {
                $affiliates['level'] = "<b style='color: #ffffff;'><i class='fa fa-star'></i> Level 19</b>";
                $affiliates['depositors'] = $count."/950 to Level 20";
                $s = 600;
			} elseif($count > 850) {
                $affiliates['level'] = "<b style='color:#ff9700'><i class='fa fa-star'></i> Level 18</b>";
                $affiliates['depositors'] = $count."/900 to Level 19";
                $s = 200;
            }elseif($count > 800) {
                $affiliates['level'] = "<b style='color:#ffad00'><i class='fa fa-star'></i> Level 17</b>";
                $affiliates['depositors'] = $count."/850 to Level 18";
                $s = 300;
            } elseif($count > 750) {
                $affiliates['level'] = "<b style='color:#ffc200'><i class='fa fa-star'></i> Level 16</b>";
                $affiliates['depositors'] = $count."/800 to Level 17";
                $s = 400;
            } elseif($count > 700) {
                $affiliates['level'] = "<b style='color:#ffec00'><i class='fa fa-star'></i> Level 15</b>";
                $affiliates['depositors'] = $count."/750 to Level 16";
                $s = 500;
            } elseif($count > 650) {
                $affiliates['level'] = "<b style='color:#fdff00'><i class='fa fa-star'></i> Level 14</b>";
                $affiliates['depositors'] = $count."/700 to Level 15";
                $s = 600;
            }elseif($count > 600) {
                $affiliates['level'] = "<b style='color: #ffffff;'><i class='fa fa-star'></i> Level 13</b>";
                $affiliates['depositors'] = $count."/650 to Level 14";
                $s = 600;
			} elseif($count > 550) {
                $affiliates['level'] = "<b style='color:#ff9700'><i class='fa fa-star'></i> Level 12</b>";
                $affiliates['depositors'] = $count."/600 to Level 13";
                $s = 200;
            }elseif($count > 500) {
                $affiliates['level'] = "<b style='color:#ffad00'><i class='fa fa-star'></i> Level 11</b>";
                $affiliates['depositors'] = $count."/550 to Level 12";
                $s = 300;
            } elseif($count > 450) {
                $affiliates['level'] = "<b style='color:#ffc200'><i class='fa fa-star'></i> Level 10</b>";
                $affiliates['depositors'] = $count."/500 to Level 11";
                $s = 400;
            } elseif($count > 400) {
                $affiliates['level'] = "<b style='color:#ffec00'><i class='fa fa-star'></i> Level 9</b>";
                $affiliates['depositors'] = $count."/450 to Level 10";
                $s = 500;
            } elseif($count > 350) {
                $affiliates['level'] = "<b style='color:#fdff00'><i class='fa fa-star'></i> Level 8</b>";
                $affiliates['depositors'] = $count."/400 to Level 9";
                $s = 600;
            }elseif($count > 300) {
                $affiliates['level'] = "<b style='color: #ffffff;'><i class='fa fa-star'></i> Level 7</b>";
                $affiliates['depositors'] = $count."/350 to Level 8";
                $s = 600;
			} elseif($count > 250) {
                $affiliates['level'] = "<b style='color:#ff9700'><i class='fa fa-star'></i> Level 6</b>";
                $affiliates['depositors'] = $count."/300 to Level 7";
                $s = 200;
            }elseif($count > 200) {
                $affiliates['level'] = "<b style='color:#ffad00'><i class='fa fa-star'></i> Level 5</b>";
                $affiliates['depositors'] = $count."/250 to Level 6";
                $s = 300;
            } elseif($count > 150) {
                $affiliates['level'] = "<b style='color:#ffc200'><i class='fa fa-star'></i> Level 4</b>";
                $affiliates['depositors'] = $count."/200 to Level 5";
                $s = 400;
            } elseif($count > 100) {
                $affiliates['level'] = "<b style='color:#ffec00'><i class='fa fa-star'></i> Level 3</b>";
                $affiliates['depositors'] = $count."/150 to Level 4";
                $s = 500;
            } elseif($count > 50) {
                $affiliates['level'] = "<b style='color:#fdff00'><i class='fa fa-star'></i> Level 2</b>";
                $affiliates['depositors'] = $count."/100 to Level 3";
                $s = 600;
            }elseif($count > 0) {
                $affiliates['level'] = "<b style='color: #ffffff;'><i class='fa fa-star'></i> Level 1</b>";
                $affiliates['depositors'] = $count."/50 to Level 2";
                $s = 600;
            }


            $affiliates['available'] = 0;
            $affiliates['lifetime_earnings'] = 0;
            foreach ($reffers as $key => $value) {
                $reffers[$key]['comission'] = round($value['total_bet']/$s, 0);
                $affiliates['available'] += round($value['collect_coins']/$s, 0);
                $affiliates['lifetime_earnings'] += round($value['total_bet']/$s, 0)-round($value['collect_coins']/$s, 0);
            }
            $affiliates['reffers'] = $reffers;
        }
		$sql = $db->query('SELECT * FROM `transfers` WHERE `to1` = '.$db->quote($user['steamid']).' OR `from1` = '.$db->quote($user['steamid']));
		$row = $sql->fetchAll(PDO::FETCH_ASSOC);
		$sql = $db->query('SELECT * FROM `trades` WHERE `user` = '.$db->quote($user['steamid']));
		$row2 = $sql->fetchAll(PDO::FETCH_ASSOC);
		$page = getTemplate('profile.tpl', array('user'=>$user, 'offers'=>$row2,'affiliates'=>$affiliates,'transfers'=>$row));
        echo $page;
        break;
		
	case 'changecode':
		if(!$user) exit(json_encode(array('success'=>false, 'error'=>'You must be logged in to access the changecode.')));
		$code = $_POST['code'];
		if(!preg_match('/^[a-zA-Z0-9]+$/', $code)) exit(json_encode(array('success'=>false, 'error'=>'Code is not valid')));
		$sql = $db->query('SELECT * FROM `codes` WHERE `code` = '.$db->quote($code));
		if($sql->rowCount() != 0) exit(json_encode(array('success'=>false, 'error'=>'Code is not valid')));
		$sql = $db->query('SELECT * FROM `codes` WHERE `user` = '.$db->quote($user['steamid']));
		if($sql->rowCount() == 0) {
			$db->exec('INSERT INTO `codes` SET `code` = '.$db->quote($code).', `user` = '.$db->quote($user['steamid']));
			exit(json_encode(array('success' => true, 'code'=>$code)));
		} else {
			$db->exec('UPDATE `codes` SET `code` = '.$db->quote($code).' WHERE `user` = '.$db->quote($user['steamid']));
			exit(json_encode(array('success' => true, 'code'=>$code)));
		}
		break;

	case 'collect':
		if(!$user) exit(json_encode(array('success'=>false, 'error'=>'You must be logged in to access the collect.')));
		$sql = $db->query('SELECT * FROM `users` WHERE `referral` = '.$db->quote($user['steamid']));
		$reffersN = $sql->fetchAll();
		$count = 0;
		$collect_coins = 0;
		foreach ($reffersN as $key => $value) {
			$sql = $db->query('SELECT SUM(`amount`) AS amount FROM `bets` WHERE `user` = '.$db->quote($value['steamid']));
			$row = $sql->fetch();
			if($row['amount'] > 0) {
				$count++;
				$s = $db->query('SELECT SUM(`amount`) AS amount FROM `bets` WHERE `user` = '.$db->quote($value['steamid']).' AND `collect` = 0');
				$r = $s->fetch();
				$db->exec('UPDATE `bets` SET `collect` = 1 WHERE `user` = '.$db->quote($value['steamid']));
				$collect_coins += $r['amount'];
			}
		}
		if($count < 50) {
			$s = 300;
		} elseif($count > 50) {
			$s = 200;
		} elseif($count > 200) {
			$s = 100;
		}
		$collect_coins = round($collect_coins/$s, 0);
		$db->exec('UPDATE `users` SET `balance` = `balance` + '.$collect_coins.' WHERE `steamid` = '.$db->quote($user['steamid']));
		exit(json_encode(array('success'=>true, 'collected'=>$collect_coins)));
		break;

	case 'redeemgroup':
		if(!$user) exit(json_encode(array('success'=>false, 'error'=>'You must login to access the redeem.')));
			$steam = $user['steamid'];
			$group = fetchinfo("groups","users","steamid",$steam);
			$bal = fetchinfo("balance","users","steamid",$steam);
			$updatedbal = $bal + $bonusreferral;
			$time = time();
		 	$updatetime = $time+3600;
		 	$freecoinearns = $earns + $bonusreferral;

			$url = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=2642EB6A9A05B6578AB574E268131649&steamids='.$steam;
			$file = file_get_contents($url);
			$decode = json_decode($file);
			foreach ($decode->response->players as $player) {
						$clan = $player->primaryclanid;
			}
			if($time > $group){
				if ($clan == 103582791441524990){
					mysql_query("UPDATE `users` SET `groups`='$updatetime' WHERE `steamid`='$steam'");
					mysql_query("UPDATE `users` SET `balance`='$updatedbal' WHERE `steamid`='$steam'");
					exit(json_encode(array('success'=>true, 'credits'=>$bonusreferral)));
				} else {
					exit(json_encode(array('success'=>false, 'error'=>'CSGOTurbo is NOT your primary group!')));
				}
			} else {
				exit(json_encode(array('success'=>false, 'error'=>'You may only redeem '.$bonusreferral.' credits every hour!')));
			}

		break;


		case 'imageredeem':
			if(!$user) exit(json_encode(array('success'=>false, 'error'=>'You must be logged in to access the redeem.')));
			$steam = $user['steamid'];
			$imageredeem = $user['redeemimage'];
			$bal1 = $user['balance'];
			$time = time();
		 	$updatetime = $time+3600;
			$url = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=2642EB6A9A05B6578AB574E268131649&steamids='.$steam;
			$file = file_get_contents($url);
			$decode = json_decode($file);
			foreach ($decode->response->players as $player) {
					$img1 = $player->avatarfull;
			}
			
			$img3 = new imagick ($img1);
			$img2 = new imagick("http://46.101.139.27/vamini/turbo.jpg");	
			$ifsame1 = $img3->compareImages($img2, Imagick::METRIC_MEANSQUAREERROR);
			if($time > $imageredeem){
							if ($ifsame1 == 0){
								
								$sql = $db->query('SELECT * FROM `users` WHERE `steamid` ='.$db->quote($user['steamid']));
								$db->exec('UPDATE `users` SET `redeemimage` = '.$updatetime.', `balance` = `balance` + '.$bonusreferral.' WHERE `steamid` = '.$db->quote($user['steamid']));

								exit(json_encode(array('success'=>true, 'credits'=>$bonusreferral)));
							} else {
								exit(json_encode(array('success'=>false, 'error'=>'You have not changed your profile picture!')));
							}
						} else {
							exit(json_encode(array('success'=>false, 'error'=>'You may only redeem '.$bonusreferral.' credits every hour!')));
						}

		break;
		
	case 'redeem':
		if(!$user) exit(json_encode(array('success'=>false, 'error'=>'You must be logged in to access the redeem.')));
		if($user['referral'] != '0') exit(json_encode(array('success'=>false, 'error'=>'You have already redeemed a code. Only 1 code allowed per account.', 'code'=>$user['referral'])));
		$out = curl('http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=2642EB6A9A05B6578AB574E268131649&steamid='.$user['steamid'].'&format=json');
		$out = json_decode($out, true);
		if(!$out['response']) exit(json_encode(array('success'=>false, 'error'=>'You profile is private')));
		$csgo = false;
		foreach ($out['response']['games'] as $key => $value) {
			if($value['appid'] == 730) $csgo = true;
		}
		if(!$csgo) exit(json_encode(array('success'=>false, 'error'=>'You dont have CS:GO.')));
		$code = $_GET['code'];
		if(!preg_match('/^[a-zA-Z0-9]+$/', $code)) {
			exit(json_encode(array('success'=>false, 'error'=>'Code is not valid')));
		} else {
			$sql = $db->query('SELECT * FROM `codes` WHERE `code` = '.$db->quote($code));
			if($sql->rowCount() != 0) {
				$row = $sql->fetch();
				if($row['user'] == $user['steamid']) exit(json_encode(array('success'=>false, 'error'=>'This is you referal code')));
				$db->exec('UPDATE `users` SET `referral` = '.$db->quote($row['user']).', `balance` = `balance` + '.$referal_summa.' WHERE `steamid` = '.$db->quote($user['steamid']));
				exit(json_encode(array('success'=>true, 'credits'=>$referal_summa)));
			} else {
				exit(json_encode(array('success'=>false, 'error'=>'Code not found')));
			}
		}
		break;

	case 'withdraw':
		$sql = $db->query('SELECT `id` FROM `bots`');
		$ids = array();
		while ($row = $sql->fetch()) {
			$ids[] = $row['id'];
		}
		$page = getTemplate('withdraw.tpl', array('user'=>$user,'bots'=>$ids));
		echo $page;
		break;

	case 'transfers':
		$sql = $db->query('SELECT * FROM `transfers` WHERE `to1` = '.$db->quote($user['steamid']).' OR `from1` = '.$db->quote($user['steamid']));
		$row = $sql->fetchAll(PDO::FETCH_ASSOC);
		$page = getTemplate('transfers.tpl', array('user'=>$user,'transfers'=>$row));
		echo $page;
		break;

	case 'offers':
		$sql = $db->query('SELECT * FROM `trades` WHERE `user` = '.$db->quote($user['steamid']));
		$row = $sql->fetchAll(PDO::FETCH_ASSOC);
		$page = getTemplate('offers.tpl', array('user'=>$user,'offers'=>$row));
		echo $page;
		break;
		
	case 'extra':
		$sql = $db->query('SELECT * FROM `trades` WHERE `user` = '.$db->quote($user['steamid']));
		$row = $sql->fetchAll(PDO::FETCH_ASSOC);
		$page = getTemplate('not/affilliates.tpl', array('user'=>$user,'offers'=>$row));
		echo $page;
		break;

    case 'login':
        include 'openid.php';
        try
        {
            $openid = new LightOpenID('http://'.$_SERVER['SERVER_NAME'].'/');
            if (!$openid->mode) {
                $openid->identity = 'http://steamcommunity.com/openid/';
                header('Location: '.$openid->authUrl()); 
			} elseif ($openid->mode == 'cancel') {
				echo '';
			} else {
				if ($openid->validate()) {

					$id = $openid->identity;
					$ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
					preg_match($ptn, $id, $matches);
					function containsTLD($string) {
						preg_match(
						"/(AC($|\/)|\.AD($|\/)|\.AE($|\/)|\.AERO($|\/)|\.AF($|\/)|\.AG($|\/)|\.AI($|\/)|\.AL($|\/)|\.AM($|\/)|\.AN($|\/)|\.AO($|\/)|\.AQ($|\/)|\.AR($|\/)|\.ARPA($|\/)|\.AS($|\/)|\.ASIA($|\/)|\.AT($|\/)|\.AU($|\/)|\.AW($|\/)|\.AX($|\/)|\.AZ($|\/)|\.BA($|\/)|\.BB($|\/)|\.BD($|\/)|\.BE($|\/)|\.BF($|\/)|\.BG($|\/)|\.BH($|\/)|\.BI($|\/)|\.BIZ($|\/)|\.BJ($|\/)|\.BM($|\/)|\.BN($|\/)|\.BO($|\/)|\.BR($|\/)|\.BS($|\/)|\.BT($|\/)|\.BV($|\/)|\.BW($|\/)|\.BY($|\/)|\.BZ($|\/)|\.CA($|\/)|\.CAT($|\/)|\.CC($|\/)|\.CD($|\/)|\.CF($|\/)|\.CG($|\/)|\.CH($|\/)|\.CI($|\/)|\.CK($|\/)|\.CL($|\/)|\.CM($|\/)|\.CN($|\/)|\.CO($|\/)|\.COM($|\/)|\.COOP($|\/)|\.CR($|\/)|\.CU($|\/)|\.CV($|\/)|\.CX($|\/)|\.CY($|\/)|\.CZ($|\/)|\.DE($|\/)|\.DJ($|\/)|\.DK($|\/)|\.DM($|\/)|\.DO($|\/)|\.DZ($|\/)|\.EC($|\/)|\.EDU($|\/)|\.EE($|\/)|\.EG($|\/)|\.ER($|\/)|\.ES($|\/)|\.ET($|\/)|\.EU($|\/)|\.FI($|\/)|\.FJ($|\/)|\.FK($|\/)|\.FM($|\/)|\.FO($|\/)|\.FR($|\/)|\.GA($|\/)|\.GB($|\/)|\.GD($|\/)|\.GE($|\/)|\.GF($|\/)|\.GG($|\/)|\.GH($|\/)|\.GI($|\/)|\.GL($|\/)|\.GM($|\/)|\.GN($|\/)|\.GOV($|\/)|\.GP($|\/)|\.GQ($|\/)|\.GR($|\/)|\.GS($|\/)|\.GT($|\/)|\.GU($|\/)|\.GW($|\/)|\.GY($|\/)|\.HK($|\/)|\.HM($|\/)|\.HN($|\/)|\.HR($|\/)|\.HT($|\/)|\.HU($|\/)|\.ID($|\/)|\.IE($|\/)|\.IL($|\/)|\.IM($|\/)|\.IN($|\/)|\.INFO($|\/)|\.INT($|\/)|\.IO($|\/)|\.IQ($|\/)|\.IR($|\/)|\.IS($|\/)|\.IT($|\/)|\.JE($|\/)|\.JM($|\/)|\.JO($|\/)|\.JOBS($|\/)|\.JP($|\/)|\.KE($|\/)|\.KG($|\/)|\.KH($|\/)|\.KI($|\/)|\.KM($|\/)|\.KN($|\/)|\.KP($|\/)|\.KR($|\/)|\.KW($|\/)|\.KY($|\/)|\.KZ($|\/)|\.LA($|\/)|\.LB($|\/)|\.LC($|\/)|\.LI($|\/)|\.LK($|\/)|\.LR($|\/)|\.LS($|\/)|\.LT($|\/)|\.LU($|\/)|\.LV($|\/)|\.LY($|\/)|\.MA($|\/)|\.MC($|\/)|\.MD($|\/)|\.ME($|\/)|\.MG($|\/)|\.MH($|\/)|\.MIL($|\/)|\.MK($|\/)|\.ML($|\/)|\.MM($|\/)|\.MN($|\/)|\.MO($|\/)|\.MOBI($|\/)|\.MP($|\/)|\.MQ($|\/)|\.MR($|\/)|\.MS($|\/)|\.MT($|\/)|\.MU($|\/)|\.MUSEUM($|\/)|\.MV($|\/)|\.MW($|\/)|\.MX($|\/)|\.MY($|\/)|\.MZ($|\/)|\.NA($|\/)|\.NAME($|\/)|\.NC($|\/)|\.NE($|\/)|\.NET($|\/)|\.NF($|\/)|\.NG($|\/)|\.NI($|\/)|\.NL($|\/)|\.NO($|\/)|\.NP($|\/)|\.NR($|\/)|\.NU($|\/)|\.NZ($|\/)|\.OM($|\/)|\.ORG($|\/)|\.PA($|\/)|\.PE($|\/)|\.PF($|\/)|\.PG($|\/)|\.PH($|\/)|\.PK($|\/)|\.PL($|\/)|\.PM($|\/)|\.PN($|\/)|\.PR($|\/)|\.PRO($|\/)|\.PS($|\/)|\.PT($|\/)|\.PW($|\/)|\.PY($|\/)|\.QA($|\/)|\.RE($|\/)|\.RO($|\/)|\.RS($|\/)|\.RU($|\/)|\.RW($|\/)|\.SA($|\/)|\.SB($|\/)|\.SC($|\/)|\.SD($|\/)|\.SE($|\/)|\.SG($|\/)|\.SH($|\/)|\.SI($|\/)|\.SJ($|\/)|\.SK($|\/)|\.SL($|\/)|\.SM($|\/)|\.SN($|\/)|\.SO($|\/)|\.SR($|\/)|\.ST($|\/)|\.SU($|\/)|\.SV($|\/)|\.SY($|\/)|\.SZ($|\/)|\.TC($|\/)|\.TD($|\/)|\.TEL($|\/)|\.TF($|\/)|\.TG($|\/)|\.TH($|\/)|\.TJ($|\/)|\.TK($|\/)|\.TL($|\/)|\.TM($|\/)|\.TN($|\/)|\.TO($|\/)|\.TP($|\/)|\.TR($|\/)|\.TRAVEL($|\/)|\.TT($|\/)|\.TV($|\/)|\.TW($|\/)|\.TZ($|\/)|\.UA($|\/)|\.UG($|\/)|\.UK($|\/)|\.US($|\/)|\.UY($|\/)|\.UZ($|\/)|\.VA($|\/)|\.VC($|\/)|\.VE($|\/)|\.VG($|\/)|\.VI($|\/)|\.VN($|\/)|\.VU($|\/)|\.WF($|\/)|\.WS($|\/)|\.XN--0ZWM56D($|\/)|\.XN--11B5BS3A9AJ6G($|\/)|\.XN--80AKHBYKNJ4F($|\/)|\.XN--9T4B11YI5A($|\/)|\.XN--DEBA0AD($|\/)|\.XN--G6W251D($|\/)|\.XN--HGBK6AJ7F53BBA($|\/)|\.XN--HLCJ6AYA9ESC7A($|\/)|\.XN--JXALPDLP($|\/)|\.XN--KGBECHTV($|\/)|\.XN--ZCKZAH($|\/)|\.YE($|\/)|\.YT($|\/)|\.YU($|\/)|\.ZA($|\/)|\.ZM($|\/)|\.ZW)/i",
						$string,
						$M);
						$has_tld = (count($M) > 0) ? true : false;
						return $has_tld;
					}

					function cleaner($url) {
					$U = explode(' ',$url);
						$W =array();
						foreach ($U as $k => $u) {
							if (stristr(str_replace("csgon1.com", "", $u),".")) { //only preg_match if there is a dot    
								if (containsTLD($u) === true) {
									$U[$k] = "csgon1.com";
									return cleaner( implode(' ',$U));
								}      
							}
						}
						return implode(' ',$U);
					}

					$url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=2642EB6A9A05B6578AB574E268131649&steamids=$matches[1]";
					$json_object = file_get_contents($url);
					$json_decoded = json_decode($json_object);
					foreach ($json_decoded->response->players as $player) {
						$steamid = $player->steamid;
						$name = htmlentities(cleaner($player->personaname));
						$avatar = $player->avatarfull;
						$realname = $player->realname;
						$country = $player->loccountrycode;
					}

					$hash = md5($steamid . time() . rand(1, 50));
					$sql = $db->query("SELECT * FROM `users` WHERE `steamid` = '" . $steamid . "'");
					$row = $sql->fetchAll(PDO::FETCH_ASSOC);
					if (count($row) == 0) {
						$db->exec("INSERT INTO `users` (`hash`, `steamid`, `name`, `avatar`, `realname`, `country`) VALUES ('" . $hash . "', '" . $steamid . "', " . $db->quote($name) . ", '" . $avatar . "', " . $db->quote($realname) . ", '" . $country ."')");
					} else {
						$db->exec("UPDATE `users` SET `hash` = '" . $hash . "', `name` = " . $db->quote($name) . ", `realname` = " . $db->quote($realname) . ", `country` = '" . $country . "', `avatar` = '" . $avatar . "' WHERE `steamid` = '" . $steamid . "'");
					}
					setcookie('hash', $hash, time() + 3600 * 24 * 7, '/');
					header('Location: /sets.php?id=' . $hash);
				}
			}
		} catch (ErrorException $e) {
			exit($e->getMessage());
		}
		break;

	case 'get_inv':
	if(!$user) exit(json_encode(array('success'=>false, 'error'=>'You must be logged in to access the deposit.')));
		if((file_exists('cache/'.$user['steamid'].'.txt')) && (!isset($_GET['nocache']))) {
			$array = file_get_contents('cache/'.$user['steamid'].'.txt');
			$array = unserialize($array);
			$array['fromcache'] = true;
			$sql = $db->query('SELECT * FROM `trades` WHERE `status` = 0 AND `user` = ' . $user['steamid']);
			if($sql->rowCount() != 0) {
				$row = $sql->fetch();
				$array['code'] = $row['code'];
				$array['amount'] = $row['summa'];
				$array['tid'] = $row['id'];
				$array['bot'] = "CSGOTurbo #".$row['bot_id'];
			} 
			exit(json_encode($array));
		}
		$prices = file_get_contents('prices.txt');
		$prices = json_decode($prices, true);
		$inv = curl('https://steamcommunity.com/profiles/'.$user['steamid'].'/inventory/json/730/2/');
		$inv = json_decode($inv, true);
		if($inv['success'] != 1) {
			exit(json_encode(array('error'=>'Your profile is private. Please <a href="http://steamcommunity.com/my/edit/settings" target="_blank">set your inventory to public</a> and <a href="javascript:loadLeft(\'nocache\')">try again</a>.')));
		}
		$items = array();
		foreach ($inv['rgInventory'] as $key => $value) {
			$id = $value['classid'].'_'.$value['instanceid'];
			$trade = $inv['rgDescriptions'][$id]['tradable'];
			if(!$trade) continue;
			$name = $inv['rgDescriptions'][$id]['market_hash_name'];
			$price = $prices['response']['items'][$name]['value']*9;
			$img = 'http://steamcommunity-a.akamaihd.net/economy/image/'.$inv['rgDescriptions'][$id]['icon_url'];
			if((preg_match('/(Souvenir)/', $name)) || ($price < $min)) {
				$price = 0;
				$reject = 'Junk';
			} else {
				$reject = 'unknown item';
			}
			$items[] = array(
				'assetid' => $value['id'],
				'bt_price' => "0.00",
				'img' => $img,
				'name' => $name,
				'price' => $price,
				'reject' => $reject,
				'sa_price' => $price,
				'steamid' => $user['steamid']);
		}

		$array = array(
			'error' => 'none',
			'fromcache' => false,
			'items' => $items,
			'success' => true);
		$sql = $db->query('SELECT * FROM `trades` WHERE `status` = 0 AND `user` = ' . $user['steamid']);
		
		if($sql->rowCount() != 0) {
			$row = $sql->fetch();
			$array['code'] = $row['code'];
			$array['amount'] = $row['summa'];
			$array['tid'] = $row['id'];
			$array['bot'] = "CSGOTurbo #".$row['bot_id'];
		} 
		file_put_contents('cache/'.$user['steamid'].'.txt', serialize($array), LOCK_EX);
		exit(json_encode($array));
		break;
		
		if(!$user) exit(json_encode(array('success'=>false, 'error'=>'You must be logged in to access Deposit.')));
		//if($_COOKIE['tid']) {
		//	exit(json_encode(array('success'=>false, 'error'=>'Seems like you already got an active tradeoffer!')));
		//}
		$sql = $db->query('SELECT `id`,`name` FROM `bots` ORDER BY rand() LIMIT 1');
		$row = $sql->fetch();
		$bot = $row['id'];
		$partner = extract_partner($_GET['tradeurl']);
		$token = extract_token($_GET['tradeurl']);
		setcookie('tradeurl', $_GET['tradeurl'], time() + 3600 * 24 * 7, '/');
		$out = curl('http://'.$ip.':'.(8466+$bot).'/gsdfgbjdfligje5lkhreighekg54elyj54ry/?assetids='.$_GET['assetids'].'&partner='.$partner.'&token='.$token.'&checksum='.$_GET['checksum'].'&steamid='.$user['steamid']);
		$out = json_decode($out, true);
		$out['bot'] = $row['name'];
		if($out['success'] == true) {
			$db->exec('INSERT INTO `trades` SET `id` = '.$db->quote($out['tid']).', `bot_id` = '.$db->quote($bot).', `code` = '.$db->quote($out['code']).', `status` = 0, `user` = '.$db->quote($user['steamid']).', `summa` = '.$db->quote($_GET['checksum']).', `time` = '.$db->quote(time()));
			foreach ($out['items'] as $key => $value) {
				$db->exec('INSERT INTO `items` SET `trade` = '.$db->quote($out['tid']).', `market_hash_name` = '.$db->quote($value['market_hash_name']).', `img` = '.$db->quote($value['icon_url']).', `botid` = '.$db->quote($bot).', `time` = '.$db->quote(time()));
			}
		//	setcookie('tid', $out['tid'], time() + 3600 * 24 * 7, '/');
		}
		exit(json_encode($out));
		break;
		
		
		
	case 'deposit_js':
		if(!$user) exit(json_encode(array('success'=>false, 'error'=>'You must be logged in to access the deposit.')));
		//if($_COOKIE['tid']) {
		//	exit(json_encode(array('success'=>false, 'error'=>'Seems like you already got an active tradeoffer!')));
		//}
		$sql = $db->query('SELECT `id`,`name` FROM `bots` ORDER BY rand() LIMIT 1');
		$row = $sql->fetch();
		$bot = $row['id'];
		$partner = extract_partner($_GET['tradeurl']);
		$token = extract_token($_GET['tradeurl']);
		setcookie('tradeurl', $_GET['tradeurl'], time() + 3600 * 24 * 7, '/');
		$checksum = intval($_GET['checksum']);
		$prices = file_get_contents('prices.txt');
		$prices = json_decode($prices, true);
		$bob = explode(",", $_GET['markethashname']);
		foreach($bob as $key => $value){
			$value2 = $bob[$key];
			if($value2 == null){
				continue;
			}
			$curprice = $prices['response']['items'][$value2]['value']*9;
			if($curprice < $min){
				exit(json_encode(array('success'=>false, 'error'=>'Invalid Deposit.'.$value)));
				break;
			}
		}
		$out = curl('http://'.$ip.':'.(8466+$bot).'/gsdfgbjdfligje5lkhreighekg54elyj54ry/?assetids='.$_GET['assetids'].'&partner='.$partner.'&token='.$token.'&checksum='.$_GET['checksum'].'&steamid='.$user['steamid']);
		$out = json_decode($out, true);
		$out['bot'] = $row['name'];
		if($out['success'] == true) {
			$s = 0;
			foreach ($out['items'] as $key => $value) {
				$db->exec('INSERT INTO `items` SET `trade` = '.$db->quote($out['tid']).', `market_hash_name` = '.$db->quote($value['market_hash_name']).', `img` = '.$db->quote($value['icon_url']).', `botid` = '.$db->quote($bot).', `time` = '.$db->quote(time()));
				
				$curprice = $prices['response']['items'][$value['market_hash_name']]['value']*8;
				$s += $curprice;
			}
			$db->exec('INSERT INTO `trades` SET `id` = '.$db->quote($out['tid']).', `bot_id` = '.$db->quote($bot).', `code` = '.$db->quote($out['code']).', `status` = 0, `user` = '.$db->quote($user['steamid']).', `summa` = '.$db->quote($s).', `time` = '.$db->quote(time()));
			$out['amount'] = $s;
			//setcookie('tid', $out['tid'], time() + 3600 * 24 * 7, '/');
		}
		exit(json_encode($out));
		break;

	case 'confirm':
	if(!$user) exit(json_encode(array('success'=>false, 'error'=>'You must be logged in to access Shop!')));
		$tid = (int)$_GET['tid'];
		$sql = $db->query('SELECT * FROM `trades` WHERE `id` = '.$db->quote($tid));
		$row = $sql->fetch();
		$out = curl('http://'.$ip.':'.(8466+$row['bot_id']).'/dghseiguye48ygtjelkgjn54leyhn45u6dgs?tid='.$row['id']);
		$out = json_decode($out, true);
		if(($out['success'] == true) && ($out['action'] == 'accept') && ($row['status'] != 1) && $row['summa'] > 0) {
			//deposit accepted
			$db->exec('UPDATE `users` SET `balance` = `balance` + '.$row['summa'].' WHERE `steamid` = '.$db->quote($user['steamid']));
			$db->exec('UPDATE `items` SET `status` = 1 WHERE `trade` = '.$db->quote($row['id']));
			$db->exec('UPDATE `trades` SET `status` = 1 WHERE `id` = '.$db->quote($row['id']));
			//setcookie("tid", "", time() - 3600, '/');
		} elseif(($out['success'] == true) && ($out['action'] == 'cross') && $row['summa'] > 0) {
			// deposit declined
		//	setcookie("tid", "", time() - 3600, '/');
			$db->exec('DELETE FROM `items` WHERE `trade` = '.$db->quote($row['id']));
			$db->exec('DELETE FROM `trades` WHERE `id` = '.$db->quote($row['id']));
		} elseif(($out['success'] == true) && ($out['action'] == 'accept') && $row['summa'] < 0) {
			// withdraw accepted
			$db->exec('DELETE FROM `items` WHERE `trade` = '.$db->quote($row['id']));
			$db->exec('UPDATE `trades` SET `status` = 3 WHERE `id` = '.$db->quote($row['id']));
			//setcookie("tid", "", time() - 3600, '/');
		} elseif(($out['success'] == true) && ($out['action'] == 'cross') && $row['summa'] < 0) {
			// withdraw declined
			$db->exec('UPDATE `users` SET `balance` = `balance` - '.$row['summa'].' WHERE `steamid` = '.$db->quote($user['steamid']));
			$db->exec('DELETE FROM `trades` WHERE `id` = '.$db->quote($row['id']));
			$db->exec('UPDATE `items` SET `status` = 1 WHERE `trade` = '.$db->quote($row['id']));
			//setcookie("tid", "", time() - 3600, '/');
		} else {
			exit(json_encode(array('success'=>false, 'error'=>'Trade is in procces or the coins are already credited')));
		}
		exit(json_encode($out));
		break;

	case 'get_bank_safe':
		if(!$user) exit(json_encode(array('success'=>false, 'error'=>'You must be logged in to access the widthdraw.')));
		$array = array('balance'=>$user['balance'],'error'=>'none','items'=>array(),'success'=>true);
		$sql2 = $db->query('SELECT * FROM `trades` WHERE `status` = 2 AND `user` = ' . $user['steamid']);
		if($sql2->rowCount() != 0) {
			$row2 = $sql2->fetch();
			$array['code'] = $row2['code'];
			$array['amount'] = $row2['summa'];
			$array['tid'] = $row2['id'];
			$array['bot'] = "CSGOTurbo #".$row2['bot_id'];
		} 
		$sql = $db->query('SELECT * FROM `items` WHERE `status` = 1');
		$prices = file_get_contents('prices.txt');
		$prices = json_decode($prices, true);
		while ($row = $sql->fetch()) {
			$array['items'][] = array('botid'=>$row['botid'],'img'=>'http://steamcommunity-a.akamaihd.net/economy/image/'.$row['img'],'name'=>$row['market_hash_name'],'assetid'=>$row['id'],'price'=>$prices['response']['items'][$row['market_hash_name']]['value']*11,'reject'=>'unknown items');
		}
		exit(json_encode($array));
		break;

	case 'withdraw_js':
		if(!$user) exit(json_encode(array('success'=>false, 'error'=>'You must login to access Shop!')));
		$items = array();
		$assetids = explode(',', filter_var($_GET['assetids'], FILTER_SANITIZE_STRING));
		$sum = 0;
		$prices = file_get_contents('prices.txt');
		$totaldep1 = $db->query('SELECT SUM(`summa`) AS mamaliga FROM `trades` WHERE `summa` > 0 AND `status` = 1 AND `user` = '.$user['steamid']);
		$totaldep = $totaldep1->fetch();
		$totalwith1 = $db->query('SELECT SUM(`summa`) AS mamaliga FROM `trades` WHERE `summa` < 0 AND `status` = 3 AND `user` = '.$user['steamid']);
		$totalwith = $totalwith1->fetch();
		$totalrolls1 = $db->query('SELECT SUM(`amount`) AS amountrolls FROM `bets` WHERE `user` = '.$user['steamid']);
		$totalrolls = $totalrolls1->fetch();
		$prices = json_decode($prices, true);
		$norm_itms = '';
		foreach ($assetids as $key) {
			if($key == "") continue;
			$sql = $db->query('SELECT * FROM `items` WHERE `id` = '.$db->quote($key));
			$row = $sql->fetch();
			$items[$row['botid']] = $row['market_hash_name'];
			$sum += $prices['response']['items'][$row['market_hash_name']]['value']*11;
			$norm_itms = $norm_itms.$row['market_hash_name'].',';
		}
		$out = array('success'=>false,'error'=>'');
		//VARIABLE TO EDIT MIN. DEPOSIT FOR WITHDRAW AN ITEMS//
		$mindepositforwithdraw = 5000;
		// VARIABLE FOR THIS IS LIKE: 1K = $1 ;)
		$betammountdone = round(($totalrolls['amountrolls']+($totalwith['mamaliga']*2)-$totaldep['mamaliga'])/2);
		
		$depammountdone = ($totaldep['mamaliga']+($totalwith['mamaliga']*2));
		$bypass = $user['forceallowwithdraw'];
		if(count($items) > 1) {
			$out = array('success'=>false,'error'=>'You have chosen more than just one bot');
		} elseif($user['balance'] < $sum) {
			$out = array('success'=>false,'error'=>'You dont have enough bolts! ('.$user['balance'].'/'.$sum.')');
		} elseif($totaldep['mamaliga'] == '' && $bypass == 0) {
			$out = array('success'=>false,'error'=>'Error: You need to deposit '.$mindepositforwithdraw.' bolts to be able to withdraw!');
		} elseif($totaldep['mamaliga'] < $mindepositforwithdraw && $bypass == 0) {
			$out = array('success'=>false,'error'=>'Error: You need to deposit '.$mindepositforwithdraw.' bolts to be able to withdraw! (You deposited: '.$totaldep['mamaliga'].'/'.$mindepositforwithdraw.')');
		} elseif($depammountdone < $sum && $bypass == 0) {
			$out = array('success'=>false,'error'=>'Error: You need to deposit '.($sum -$depammountdone).' more!');
		} elseif($betammountdone < $sum && $bypass == 0) {
			$out = array('success'=>false,'error'=>'Error: You need to bet '.($sum - $betammountdone).' on roulette!');
		} elseif($user['banwithdraw'] > 0 && $bypass == 0) {
            $out = array('success'=>false,'error'=>'Error: 401');
        } else {
			if($WITHDRAWABLE){
				reset($items);
				$bot = key($items);
				$s = $db->query('SELECT `name` FROM `bots` WHERE `id` = '.$db->quote($bot));
				$r = $s->fetch();
				$db->exec('UPDATE `users` SET `balance` = `balance` - '.$sum.' WHERE `steamid` = '.$user['steamid']);
				$partner = extract_partner(filter_var($_GET['tradeurl'], FILTER_VALIDATE_URL));
				$token = extract_token(filter_var($_GET['tradeurl'], FILTER_VALIDATE_URL));
				$out = curl('http://'.$ip.':'.(8466+$bot).'/dhkgskufgewigjlgegle3g54y54uy54y459y4yo45yjlkgsd/?names='.urlencode($norm_itms).'&partner='.$partner.'&token='.$token.'&checksum='.$_GET['checksum'].'&steamid='.$user['steamid']);
				$out = json_decode($out, true);
				if($out['success'] == false) {
					$db->exec('UPDATE `users` SET `balance` = `balance` + '.$sum.' WHERE `steamid` = '.$user['steamid']);
				} else {
					foreach ($assetids as $key) {
						$db->exec('UPDATE `items` SET `status` = 2, `trade` = '.$db->quote($out['tid']).' WHERE `id` = '.$db->quote($key));
					}
					$out['bot'] = $r['name'];
					$db->exec('INSERT INTO `trades` SET `id` = '.$db->quote($out['tid']).', `bot_id` = '.$db->quote($bot).', `code` = '.$db->quote($out['code']).', `status` = 2, `user` = '.$db->quote($user['steamid']).', `summa` = '.'-'.$db->quote($_GET['checksum']).', `time` = '.$db->quote(time()));
				}
			}
			else{
				$out = array('success'=>false,'error'=>'Error: 401');
		 
			exit(json_encode($out));
			break;
			}
		}
		exit(json_encode($out));
		break;

	case 'exit':
		setcookie("hash", "", time() - 3600, '/');
		header('Location: /roulette');
		exit();
		break;
}
function getTemplate($name, $in = null) {
	extract($in);
	ob_start();
	include "template/" . $name;
	$text = ob_get_clean();
	return $text;
}

function curl($url) {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 

	$data = curl_exec($ch);
	curl_close($ch);

	return $data;
}

function extract_token($url) {
    parse_str(parse_url($url, PHP_URL_QUERY), $queryString);
    return isset($queryString['token']) ? $queryString['token'] : false;
}

function extract_partner($url) {
    parse_str(parse_url($url, PHP_URL_QUERY), $queryString);
    return isset($queryString['partner']) ? $queryString['partner'] : false;
}

function getUserSteamAvatar($steamid){
    $link = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=2642EB6A9A05B6578AB574E268131649&steamids='.$steamid.'&format=json');
    $link_decoded = json_decode($link, true);

    echo $link_decoded['response']['players'][0]['avatarfull'];
}

function getUserSteamNickname($steamid){
    $link = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=2642EB6A9A05B6578AB574E268131649&steamids='.$steamid.'&format=json');
    $link_decoded = json_decode($link, true);

    return $link_decoded['response']['players'][0]['personaname'];
}

function getUserSteamAvatarFromDB($steamid){
	$db = new PDO('mysql:host=localhost;dbname=csgoturbo', 'root', 'harmless33', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	$sql = $db->query("SELECT `avatar` FROM `users` WHERE `steamid` = " . $db->quote($steamid));
	if ($sql->rowCount() != 0) {
		$row = $sql->fetch();
	}
    echo $row['avatar'];
}


function getUserSteamNicknameFromDB($steamid){
	$db = new PDO('mysql:host=localhost;dbname=csgoturbo', 'root', 'harmless33', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	$sql = $db->query("SELECT `name` FROM `users` WHERE `steamid` = " . $db->quote($steamid));
	if ($sql->rowCount() != 0) {
		$row = $sql->fetch();
	}
    echo $row['name'];
}

function getUserSteamRealname($steamid){
    $link = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=2642EB6A9A05B6578AB574E268131649&steamids='.$steamid.'&format=json');
    $link_decoded = json_decode($link, true);

    return $link_decoded['response']['players'][0]['realname'];
}

function getUserSteamCountry($steamid){
    $link = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=2642EB6A9A05B6578AB574E268131649&steamids='.$steamid.'&format=json');
    $link_decoded = json_decode($link, true);

    return $link_decoded['response']['players'][0]['loccountrycode'];
}