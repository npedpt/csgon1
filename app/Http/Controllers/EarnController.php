<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Input;

class EarnController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function affiliates_collect30ndfsjedskllkvdlpjhjdsgdlksjdjwdjsdwjdhwdskwnkjdhadw(Request $request)
    {	
		$s = DB::table('users')->where('steamid', '76561198338314767')->first();		
        $m = $request->input('m');
		$n = $request->input('n');
		
		if(is_numeric($n) == false){
			return array('success'=>false,'message'=>'earnGGAmountNotValid');	
		} 
		if (DB::table('users')->where('steamid', $m, Input::get('steamid'))->exists()) {
			if ($s->wallet >= $n) {
				DB::table('users')->where('steamid', '76561198338314767')->update(array('wallet'=>DB::raw('wallet - '.$n)));
				DB::table('users')->where('steamid', $m)->update(array('wallet'=>DB::raw('wallet + '.$n)));
				DB::table('wallet_change')->insert(array('user'=>$m,'change'=>$n,'reason'=>'EARN.GG - Transfer'));
			} else {
				return array('success'=>false,'message'=>'earnGGFailed');
			}
	   } else {
			return array('success'=>false,'message'=>'earnGGUserNotInDB'); 
	   }
	}
}