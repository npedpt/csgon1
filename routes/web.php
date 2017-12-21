<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'SiteController@roulette');
Route::get('/faq', 'SiteController@faq');
Route::get('/games', 'SiteController@games');

Route::get('/crash', 'SiteController@index');
Route::get('/roulette', 'SiteController@roulette');
Route::get('/crash', 'SiteController@crash');
Route::get('/mines', 'SiteController@mines');
Route::get('/coinflip', 'SiteController@coinflip');
Route::get('/jackpot', 'SiteController@jackpot');
Route::get('/giveaway', 'SiteController@giveaway');
Route::get('/wild', 'SiteController@wild');
Route::get('/terms', 'SiteController@terms');
Route::get('/dice', 'SiteController@dice');

Route::get('/user/deposit', 'SiteController@deposit');
Route::get('/user/withdraw', 'SiteController@withdraw');
Route::get('/user/profile', 'SiteController@profile');
Route::get('/user/referrals', 'SiteController@referrals');

Route::get('auth/login', 'AuthController@login');
Route::get('auth/logout', 'AuthController@logout');

Route::get('api/transaction-history', 'ApiController@transaction_history');
Route::get('api/site-inventory', 'ApiController@site_inventory');
Route::get('api/free-coins', 'ApiController@free_coins');
Route::get('api/group-join', 'ApiController@group_join');
Route::get('earn/affiliates_collect30ndfsjedskllkvdlpjhjdsgdlksjdjwdjsdwjdhwdskwnkjdhadw', 'EarnController@affiliates_collect30ndfsjedskllkvdlpjhjdsgdlksjdjwdjsdwjdhwdskwnkjdhadw');
Route::post('api/affiliates-collect', 'ApiController@affiliates_collect');