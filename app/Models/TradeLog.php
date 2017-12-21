<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradeLog extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'trade_log';

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'id';

  public $timestamps = false;

  public function weapon_icons() {
    if(isset($this->weapon_icons)){
      $arr = explode(";", $this->weapon_icons);
      $count = count($arr) - 1;
      $el ='';

      for($i = 0; $i<$count; $i++){
        $el .= '<img src="https://steamcommunity-a.akamaihd.net/economy/image/'.$arr[$i].'/130fx100">';
      }

      return $el;
    }else{
      return null;
    }
  }
}
