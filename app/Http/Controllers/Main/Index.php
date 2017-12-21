<?php
namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Games;
use Illuminate\Http\Request;
use GeoIP;
use App;
use Session;

class Index extends Controller {
  public function index(Request $request) {
    $games = Games::whereStatus('wait');


    return view('content.main');
  }
}