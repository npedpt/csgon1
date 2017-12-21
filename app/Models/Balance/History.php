<?php
namespace App\Models\Balance;

use App\User;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 * @property integer $steam_id
 * @property string $action
 * @property double $amount
 * @property string $params
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class History extends \Eloquent {
  //пополнение баланса
  const REFILL = 'refill';
  //списание баланса
  const DEBIT = 'debit';
  //покупка в магазине
  const BUY = 'buy';

  /**
   * Название таблицы в базе данных
   *
   * @var string
   */
  protected $table = 'balance_history';

  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = false;

  /**
   * @return User
   */
  public function user() {
    return User::find($this->steam_id);
  }

  public function param($name = null, $default = null) {
    $params = json_decode($this->params, true);

    if(!is_array($params))
      return null;
    if($name)
      return array_get($params, $name, $default);

    return $params;
  }

  /**
   * @param $steam_id int    идентификатор пользователя
   * @param $action string   действие
   * @param $amount double   сумма
   * @param array $params    массив с параметрами, для описания, за что списан/пополнен баланс
   */
  static function add($steam_id, $action, $amount, $params = []) {
    $history = new self;
    $history->steam_id = $steam_id;
    $history->action = $action;
    $history->amount = $amount;
    $history->params = json_encode($params);
    $history->save();
  }
}