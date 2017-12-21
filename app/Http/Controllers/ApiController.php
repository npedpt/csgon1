<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Input;

class ApiController extends Controller
{
    public function transaction_history()
    {
    	if (Auth::check()){
            $results = DB::table('wallet_change')->where('user', Auth::user()->steamid)->get();
            return $results;
        }
        else {
            return redirect('auth/login');
        }
    }

    public function site_inventory()
    {
        $content = Storage::disk('prices')->get('prices.txt');
        $prices = json_decode($content, true);
        $results = DB::table('inventory')->where('in_trade', '0')->get();
        $results = json_decode($results, true);
        $output_prices = [];
        foreach($results as $key => $value){
            if($prices[$value['market_hash_name']])
            $price = $prices[$value['market_hash_name']]*1100;
            else
            $price = 0;
            array_push($output_prices, array('market_hash_name'=>$value['market_hash_name'],'price'=>$price));
        }
        return array('inventory'=>$results,'prices'=>$output_prices);
    }

    public function free_coins()
    {
        if (Auth::check()){
            if(Auth::user()->banned) return;
            if(strpos(Auth::user()->username, 'csgon1.com') !== false) {
                if(Auth::user()->csgo == 'true'){
                    if(Auth::user()->last_free_use + 86400 < time()){
                        DB::table('users')->where('steamid', Auth::user()->steamid)->update(array('wallet'=>DB::raw('wallet + 100'), 'last_free_use'=>time()));
                        DB::table('wallet_change')->insert(array('user'=>Auth::user()->steamid,'change'=>100,'reason'=>'Free coins '.date("Y-m-d H:i:s")));
                        return array('success'=>true,'message'=>'freeSuccess','payload'=>array(100),'value'=>'100');
                    } else {
                        $seconds = (Auth::user()->last_free_use + 86400) - time();
                        $days    = floor($seconds / 86400);
                        $hours   = floor(($seconds - ($days * 86400)) / 3600);
                        $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
                        $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
                        return array('success'=>false,'message'=>'freeUsed','payload'=>array($hours,$minutes,$seconds));
                    }
                } else {
                    return array('success'=>false,'message'=>'freeNoCS');
                }
            }
            else
            return array('success'=>false,'message'=>'freeBadNickname','payload'=>array('csgon1.com'));
        }
        else {
            return redirect('auth/login');
        }
    }

    public function group_join()
    {
        if (Auth::check()){
            if(Auth::user()->banned) return;
            if(Auth::user()->csgo == 'true'){
                if(Auth::user()->group_used == 0){
                if(Auth::user()->last_group_use + 150 < time()){
            
			
			$clan = 0;
			$steam = Auth::user()->steamid;
			$in_group = 0;
			$url = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=50620E0F814C69F6EFF221E0FE09E3DF&steamids='.$steam;
			$file = file_get_contents($url);
			$decode = json_decode($file);
			foreach ($decode->response->players as $player) {
						$clan += $player->primaryclanid;
			} 
			if($clan == 103582791458239689) {
				$in_group = 1;
			}
                    

                    DB::table('users')->where('steamid', Auth::user()->steamid)->update(array('last_group_use'=>time()));
                    if($in_group == 1){
                        DB::table('users')->where('steamid', Auth::user()->steamid)->update(array('group_used'=>'1'));
                        DB::table('users')->where('steamid', Auth::user()->steamid)->update(array('wallet'=>DB::raw('wallet + 30')));
                        DB::table('wallet_change')->insert(array('user'=>Auth::user()->steamid,'change'=>'30','reason'=>'Free coins - group'));
                        return array('success'=>true,'message'=>'freeSuccess','payload'=>array(30),'value'=>'30');
                    } else {
                        return array('success'=>false,'message'=>'freeNotInGroup');
                }
				} else {
                    $seconds = (Auth::user()->last_group_use + 150) - time();
                    $m = date("i", $seconds);
                    $s = date("s", $seconds);
                    return array('success'=>false,'message'=>'freeCooldown','payload'=>array($m,$s));
                }
            } else {
                return array('success'=>false,'message'=>'freeAlreadyUsed');
            }
            } else {
                return array('success'=>false,'message'=>'freeNoCS');
            }
        }
        else {
            return redirect('auth/login');
        }
    }

    public function affiliates_collect()
    {
        if(empty(Input::get('targetSID'))) return array('success'=>false,'reason'=>'affiliatesNoIDSupplied');
        if(gettype(Input::get('targetSID')) !== 'string') return array('success'=>false,'reason'=>'affiliatesNoIDSupplied');
        $user = DB::table('users')->where('steamid', htmlentities(strip_tags(Input::get('targetSID'))))->get()->first();
        if(count($user) < 1) return array('success'=>false,'reason'=>'affiliatesNoUserFound');
        if(empty($user->code)) return array('success'=>false,'reason'=>'affiliatesNoReferral');
        if(strlen($user->code) > 0) $rows = DB::table('users')->where(['inviter' => $user->steamid])->get()->count(); else $rows = 0;
        if($rows >= 1500){
            $fee = 100;
        } else if($rows > 250){
            $fee = 70; 
        } else if($rows > 50){
            $fee = 60;
        } else {
            $fee = 50; 
        }
        $profit = ($rows * $fee) - $user->collected;
        if($profit < 1) return array('success'=>false,'reason'=>'affiliatesNoCoinsToCollect');
        DB::table('users')->where('steamid', htmlentities(strip_tags(Input::get('targetSID'))))->update(array('collected'=>DB::raw('collected + '.$profit),'wallet'=>DB::raw('wallet + '.$profit)));
        DB::table('wallet_change')->insert(array('user'=>htmlentities(strip_tags(Input::get('targetSID'))),'change'=>$profit,'reason'=>'Affiliates - '.Input::get('targetSID')));
        return array('success'=>true,'reffered' => $rows, 'profit' => $profit);
    }
}