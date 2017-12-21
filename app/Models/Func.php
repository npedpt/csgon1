<?php
namespace App\Models;

use App;
use Cache;
use Auth;

class Func {

  static function updateBalance($sum, $operation, $plus) {

    $user = Auth::user();

    if($plus) {
      $user->balance += $sum;
      if (!$user->save()) {
        \Log::info("Steam ID [" . $user->steam_id . "] Ошибка в пополнении счета [" . $sum . "] - [".$operation."]");
        return false;
      }else{
        \Log::info("Steam ID [" . $user->steam_id . "] пополнил счет [" . $sum . "] - [".$operation."]");
        return true;
      }
    }else{
      $user->balance -= $sum;
      if (!$user->save()) {
        \Log::info("Steam ID [" . $user->steam_id . "] Ошибка в списании средств [" . $sum . "] - [".$operation."]");
        return false;
      }else{
        \Log::info("Steam ID [" . $user->steam_id . "] списались средства [" . $sum . "] - [".$operation."]");
        return true;
      }
    }


  }


  static function getPrice() {
    return Cache::remember('dataPrice', 10, function() {
      $priceBD = file_get_contents("http://backpack.tf/api/IGetMarketPrices/v1/?key=" . config('setting.backpack.key') . "&compress=1&appid=730");
      return (array) json_decode($priceBD, TRUE);
    });
  }

  static function getItemPrice($name) {
    $prices = Cache::remember('getItemPrice', 3600, function() {
      $content = @file_get_contents("https://api.csgofast.com/price/all");

      $json = json_decode($content, true);

      return $json;
    });
    foreach($prices as $key => $price) {
      if($key == $name)
        return $price;
    }
    return 0;
  }

  static function getCurrencyRate() {
    $currency = Cache::remember('getCurrencyRate', 3600, function() {
      $content = @file_get_contents("https://query.yahooapis.com/v1/public/yql?q=select+*+from+yahoo.finance.xchange+where+pair+=+%22USDRUB,EURRUB%22&lang=ru&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=");

      $json = json_decode($content, true);

      return array_get($json, 'query.results.rate');
    });

    //App::getLocale() == 'ru' ? 1 : 1

    return round(array_get($currency[0], 'Rate'));
  }
}