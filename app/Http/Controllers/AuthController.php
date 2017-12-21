<?php

namespace App\Http\Controllers;

use Invisnik\LaravelSteamAuth\SteamAuth;
use App\User;
use Auth;

class AuthController extends Controller
{
    /**
     * @var SteamAuth
     */
    private $steam;

    public function __construct(SteamAuth $steam)
    {
        $this->steam = $steam;
    }

    public function login()
    {
        if ($this->steam->validate()) {
            $info = $this->steam->getUserInfo();
            if (!is_null($info)) {
                $info->personaname = secureoutput($info->personaname);
                $api_url =  "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=2699D2131AEDA4F30A52790D803A1AE0&steamid=$info->steamID64&format=json";
                $json = json_decode(file_get_contents($api_url), true);
                if (!is_null($info)){
					$csgo = 'false';
					$owned = 0;
					$wallet = 10000;					
					foreach($json['response'] as $resp => $game_count)
                    {
                        if($game_count == 0){
                            $csgo = 'false';
							$owned = 0;
                        } else {
							$owned = 1;
						}
                    }
					if($owned == 1) { 
                    foreach($json['response']['games'] as $games => $appid)
                    {
                        if($appid['appid'] == 730){
                            $csgo = 'true';
                        }
                    }
					}
                    $user = User::where('steamid', $info->steamID64)->first();
                    if (is_null($user)) {
                        $user = User::create([
                            'username' => $info->personaname,
                            'avatar'   => $info->avatarfull,
                            'steamid'  => $info->steamID64,
                            'wallet'  => $wallet,
                            'csgo' => $csgo
                        ]);
                    } else {
                        $user->update(array('username' => $info->personaname,'avatar' => $info->avatarfull,'wallet' => $wallet,'csgo' => $csgo));
                    }
                    Auth::login($user, true);
                    return redirect('/games'); // redirect to site
                }
            }
        }
        return $this->steam->redirect(); // redirect to Steam login page
    }

    public function logout()
    {
    	Auth::logout();
    	return redirect('/'); // redirect to site
    }
}

function secureoutput($string)
{
    $string=htmlentities(strip_tags($string));
    $string=str_replace('>', '', $string);
    $string=str_replace('<', '', $string);
    $string=htmlspecialchars($string);
    return $string;
}
