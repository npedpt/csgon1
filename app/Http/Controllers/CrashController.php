<?php

namespace App\Http\Controllers;

use App\User;
use App\CrashGame;
use App\CrashBet;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Cache;

use Storage;
use DB;

class CrashController extends Controller {
	const NEW_BET_CHANNEL = 'betCrash';
	const WINNER_CHANNEL = 'winnerCrash';
	public $game;
	public function __construct()
    {
        parent::__construct();
        $this->game = $this->getLastGame();
    }
	public function generateSecret(){
  $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
  $numChars = strlen($chars);
  $string = '';
  for ($i = 0; $i < 16; $i++) {
    $string .= substr($chars, rand(1, $numChars) - 1, 1);
  }
  return $string;
}
	public function getLastGame()
    {
        $game = CrashGame::orderBy('id', 'desc')->first();
        if (is_null($game)) $game = $this->newGame();
        return $game;
    }
	public function newGame()
    {
		$minnumber = DB::table('crashbets')->where('crash_game_id', $this->game->id+1)->min('number');
		$profit = CrashGame::where('status',CrashGame::STATUS_FINISHED)->sum('profit');
		if($profit<0){
			if($minnumber){
				if(mt_rand(1, 3) != 1){
				$number = $minnumber-0.03;
			}else{
				$number = "1.1". mt_rand(1, 3);
			}
			}else{
				if(mt_rand(1, 3) != 1){
				$number = "1.1". mt_rand(1, 3);
			}else{
			$number = mt_rand(1, 10).".". mt_rand(1, 9) . mt_rand(1, 9);
			}
			}
		}else{
			$number = mt_rand(1, 10).".". mt_rand(1, 9) . mt_rand(1, 9);
		}
		$rand_number = $this->generateSecret();
        $game = CrashGame::create(['rand_number' => $rand_number,'number' => $number]);
        $game->hash = md5(''.$game->rand_number.''.$game->number.'');
        $game->rand_number = 0;
		$game->number = 0;
        return $game;
    }
	public function finishGame()
    {
    $winners = DB::table('crashbets')->where('crash_game_id', $this->game->id)->where('number','<=', $this->game->number)->get();
	$profit = 0;
	foreach ($winners as $winner){
        $user = User::where('id', $winner->user_id)->first();
		$user->money += $winner->price * $winner->number;
		$user->save();
		$profit += $winner->price * $winner->number;
		$this->redis->publish(self::WINNER_CHANNEL, json_encode(['steamid' => $user->steamid64,'msg' => 'Вы выиграли ' .$winner->price * $winner->number.'руб.']));
		}
		$profit = DB::table('crashgames')->where('id', $this->game->id)->pluck('price') - $profit;
		$this->game->profit = $profit;
		$this->game->save();
    }
	public function setGameStatus(Request $request)
    {
        $this->game->status = $request->get('status');
        $this->game->save();
        return $this->game;
    }
	public function index(){
        $game = CrashGame::orderBy('id', 'desc')->first();
		$games = CrashGame::Where('status',CrashGame::STATUS_FINISHED)->orderBy('id', 'desc')->take(8)->get();
		$gameclassic = DB::table('games')->where('id', \DB::table('games')->max('id'))->pluck('price');
		$gamedouble = DB::table('double_games')->where('id', \DB::table('double_games')->max('id'))->pluck('price');
		if($this->game->status == CrashGame::STATUS_FINISHED){
			$bets = DB::table('crashbets')->where('crash_game_id', $this->game->id+1)->orderBy('id','DESC')->get();
		}else{
			$bets = DB::table('crashbets')->where('crash_game_id', $this->game->id)->orderBy('id','DESC')->get();
		}			
		return view('pages.crash', compact('game','bets','games','gameclassic','gamedouble'));
	}
public function newBet(Request $request)
    {
        if (\Cache::has('crash.user.' . $this->user->id))
		return response()->json(['success' => false, 'msg' => 'Подождите...']);
		\Cache::put('crash.user.' . $this->user->id, '', 1);
        $bets = DB::table('crashbets')->where('crash_game_id', $this->game->id+1)->where('user_id', $this->user->id)->count();
		if ($bets>=1) return response()->json(['text' => 'Ошибка. Можно ставить только 1 раз за игру.', 'type' => 'error']);
        if (!$request->has('price')) return response()->json(['text' => 'Ошибка. Попробуйте обновить страницу.', 'type' => 'error']);
        if ($this->game->status == CrashGame::STATUS_PLAYING) return response()->json(['text' => 'Дождитесь следующей игры!', 'type' => 'error']);
        $price = $request->get('price');
		$number = $request->get('number');
		if ($number<=1) return response()->json(['text' => 'Ошибка. Нельзя ставить на X меньше 1', 'type' => 'error']);
            if ($this->user->money >= $price) {		
					$bet = new CrashBet();
					$bet->user()->associate($this->user);
					$bet->price = $price;
					$bet->number = $number;
					$bet->crash_game_id=$this->game->id+1;
					$bet->save();					
					$this->game->price += $price;
					$this->game->save();
                	$this->user->money = $this->user->money - $price;
                	$this->user->save();
					$bet = CrashBet::where('user_id',$this->user->id)->orderBy('id', 'desc')->first();
				$returnValue = [
                    'betnumber' => $bet->number,
					'betsum' => $bet->price,
					'price' => $this->game->price,
                    'userid' => $this->user->id,
					'username' => $this->user->username,
					'userava' => $this->user->avatar,
                ];
                $this->redis->publish(self::NEW_BET_CHANNEL, json_encode($returnValue));
                return response()->json(['text' => 'Действие выполнено.', 'type' => 'success']);
            } else {
                return response()->json(['text' => 'Недостаточно средств на балансе', 'type' => 'error']);
            }
    }
}