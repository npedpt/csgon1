<?php

namespace App\Models;

class BackEnd {

  static function send($method, $data = []) {
    $hash = self::_hash($data);

    $fields = http_build_query([
      'method' => $method,
      'data' => $data,
      'hash' => 'afdgttrr'
    ]);

	
	
    //open connection
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, config('setting.backend.url'));

    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Bot (' . url('/') . ')');

    //execute post
    $result = @curl_exec($ch);

    //close connection
    curl_close($ch);

    //file_put_contents("https://csgozone.ws/public/file.txt", $result);

    //dd($result);

    return json_decode($result, true);
  }

  private static function _hash($data) {
    $hash = "";
    foreach($data as $key => $item) {
      $hash .= $key;
      if(is_array($item))
        $hash .= self::_hash($item);
      else
        $hash .= $item;
      $hash .= config('setting.backend.secret_key');
    }
    return $hash;
  }
}
