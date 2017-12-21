<?php

namespace App\Models;

use App\User;
use Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Games
 *
 * @property string $id
 * @property integer $owner_id
 * @property integer $enemy_id
 * @property float $bet
 * @property string $owner_team
 * @property string $enemy_team
 * @property string $winner_team
 * @property int $winner_id
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Games whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Games whereOwnerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Games whereEnemyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Games whereBet($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Games whereOwnerTeam($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Games whereEnemyTeam($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Games whereWinner($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Games whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Games whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Games whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $verify
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Games whereVerify($value)
 */
class Games extends Model {
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'games';

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'id';

  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = false;

  /**
   * @return \Illuminate\Database\Eloquent\Collection|Model|User
   */
  public function owner() {
    return User::find($this->owner_id);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Collection|Model|User
   */
  public function enemy() {
    return User::find($this->enemy_id);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Collection|Model|null|User
   */
  public function winner() {
    if($this->status != 'end') {
      return null;
    }

    return User::find($this->winner_id);
  }

  public function getSubId() {
    $begin = substr($this->id, 0, 8);
    $end = substr($this->id, strlen($this->id) - 12, strlen($this->id) - 1);

    return $begin . " ... " . $end;
  }

  /**
   * @param null $user_id
   * @return bool
   */
  public function isWinner($user_id = null) {
    if(!$user_id) {
      $user_id = Auth::id();
    }

    if($this->status != 'end') {
      return false;
    }

    return $this->winner_id == $user_id;
  }

  /**
   * @param null $key
   * @return array
   */
  public function verify($key = null) {
    $verify = json_decode($this->verify, true);

    if(!$key) {
      return $verify;
    }

    return array_get($verify, $key);
  }
}
