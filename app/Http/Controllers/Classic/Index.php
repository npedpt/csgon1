<?php

namespace App\Http\Controllers\Classic;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\User;
use App\Models\Classic\Bets;
use App\Models\Classic\Games;
use Auth;

class Index extends Controller
{

  const NEW_BET = 'new.bett';

  public function __construct()
  {
    $this->game = $this->getLastGame();
  }

  public function index()
  {

    $bets = Bets::orderBy('id', 'desc')->where('game_id', $this->game->id)->get();

    $games = Games::orderBy('id', 'desc')->where('status', 2)->take(5)->get();

    foreach($games as $key => $game){
      $userB = Bets::where('game_id', $game->id)->where('id_s', $game->number)->first();

      $user = User::find($userB->user_id);

      $games[$key]['avatar'] = $user->avatar;

      $games[$key]['username'] = $user->username;

      //array_merge($game, ['avatar'=>$user->avatar]);

      //$game += ['avatar'=>$user->avatar];

      $users = Bets::where('game_id', $game->id)->get();
      $fin_sum = 0;
      foreach ($users as $user){
        $fin_sum += $user->sum;
      }

      $fin_com = $fin_sum * 0.1;

      $games[$key]['win'] = $fin_sum - $fin_com;
    }

    foreach ($bets as $bet) {
      $bet->user = User::find($bet->user_id);
    }

    $users = Bets::where('game_id', $this->game->id)->get();
    $fin_sum = 0;
    foreach ($users as $user){
      $fin_sum += $user->sum;
    }

    return view('content.classic', compact('bets', 'games', 'fin_sum'));

  }

  public function getBalance()
  {
    $user = auth()->user();
    return $user->balance;
  }

  public function getWinners()
  {

    $users = Bets::where('game_id', $this->game->id)->get();
    $cnt_users = count($users);
    //$random = rand(1, $cnt_users);
	
	$fin_sum = 0;
    foreach ($users as $user){
      $fin_sum += $user->sum;
    }
	
	$massiv = array();
	
	foreach ($users as $user){
		$chance = round($user->sum / $fin_sum, 2) * 100;
		for($i = 0; $i < $chance; $i++){
			$massiv[] = $user;
		}
	}
	
	$fin_com = $fin_sum * 0.1;

    $fin_sum -= $fin_com;
	
	$random = rand(1, 100);

    $win = $random;

	\Log::debug($random.'|'.$win);
	
    $this->game->number = $massiv[$win]['id_s'];
    $this->game->save();

    $winner = $massiv[$win];

    $user = User::find($winner->user_id);
    $this->game->avatar = $user->avatar;
    $this->game->username = $user->username;
    $this->game->fin_sum = $fin_sum;

    $user->balance += $fin_sum;

    $user->save();

    return $this->game;

  }

  public function getPlayers(){
    $users = Bets::where('game_id', $this->game->id)->get();
    foreach ($users as $user) {
      $userR = User::find($user->user_id);
      $user->avatar = $userR->avatar;
    }

    $data['users'] = $users;
    $data['count'] = count($users);

    return $data;
  }

  public function setGameStatus(Request $request)
  {
    $this->game->status = $request->get('status');
    $this->game->save();
    return $this->game;
  }

  public function getCurrentGame()
  {
    return $this->game;
  }

  public function getLastGame()
  {
    $game = Games::orderBy('id', 'desc')->first();
    if (is_null($game)) $game = $this->newGame();
    return $game;
  }

  public function newGame()
  {
    $game = Games::create(['status' => 1]);
    return $game;

  }

  public function newBetinapi()
  {
    $redis = Redis::connection('classic');

    $data = $redis->lrange('bets.list', 0, -1);
    foreach ($data as $newBetJson) {
      $bets = json_decode($newBetJson);
      $bet = Bets::create(['game_id' => $bets->gameid, 'user_id' => $bets->user_id, 'sum' => $bets->sum]);
      $bet->user = User::find($bet->user_id);
      $all = Bets::where('game_id', $bet->gameid)->sum('sum');
      $redis->publish(self::NEW_BET, json_encode(['status' => 'success', 'id' => $bet->id, 'all' => $all, 'game_id' => $bet->game_id, 'html' => view('includes.bet', compact('bet'))->render()]));
      $redis->lrem('bets.list', 0, $newBetJson);
    }
    return response()->json(['success' => true]);

  }

  function newbet(Request $request)
  {

    $redis = Redis::connection('classic');

    $user = Auth::user();

    if(!Auth::check()) {
      return ["status" => "error_game", "msg" => "Log-in please."];
    }

    if ($user->balance < $request->get('sum')) return ["status" => "error_game", "msg" => "You need to add balance!"];

    if ($request->get('sum') < 0.1) return ["status" => "error_game", "msg" => "Minimum bet is 0.1 diamonds"];

    if ($request->get('sum') > 99999) return ["status" => "error_game", "msg" => "Maxmimum bet is 999 diamonds!"];

    if ($this->game->status > 0 and $this->game->status < 4) {
      return ["status" => "error_game", "msg" => "Game is over! Your bet was rejected."];
    }


    $betSum = number_format($request->get('sum'), 2);

    $searchBets = Bets::where('game_id', $this->game->id)->where('user_id', $user->steam_id)->first();
    if($searchBets){
      $endsum = $searchBets->sum + $request->get('sum');
      $searchBets->sum += $request->get('sum');
      $searchBets->save();

      $bets = Bets::where('game_id', $this->game->id)->sum('sum');

      $user->balance -= $request->get('sum');
      $user->save();

      $redis->publish(self::NEW_BET, json_encode(['status' => 'success', 'id' => $searchBets->id, 'isset' => true, 'sum'=> $endsum, 'steam'=> $searchBets->user_id, 'all' => $bets, 'game_id' => $this->game->id, 'html' => view('content.bets.bet_classic', ['bet' => $searchBets])->render()]));

    }else{
      $bets_t = Bets::where('game_id', $this->game->id)->get();
      if(count($bets_t) < 1){
        $bet_n  = 1;
      }else{
        $bet_cnt = count($bets_t);
        $bet_n = $bet_cnt + 1;
      }

      if($bet_n > 1){
        $this->game->status = 0;
        $this->game->save();
      }

      $bet = Bets::create(['game_id' => $this->game->id, 'user_id' => $user->steam_id, 'sum' => $betSum, 'id_s' => $bet_n]);

      $bets = Bets::where('game_id', $this->game->id)->sum('sum');

      $user->balance -= $request->get('sum');
      $user->save();

      $redis->publish(self::NEW_BET, json_encode(['status' => 'success', 'id' => $bet->id, 'isset' => false, 'sum'=> $bet->sum, 'steam'=> $bet->user_id, 'all' => $bets, 'game_id' => $this->game->id, 'html' => view('content.bets.bet_classic', ['bet' => $bet])->render()]));

    }



    //return json_encode(['status' => 'success', 'id' => $bet->id, 'all' => $zero + $red + $black, 'red' => $red, 'zero' => $zero, 'black' => $black, 'game_id' => $this->game->id, 'operation' => $request->get('operation')]);

  }
}
