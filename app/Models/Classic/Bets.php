<?php

namespace App\Models\Classic;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\User;

class Bets extends Model
{
  protected $table = 'bets_classic';

  protected $fillable = ['game_id', 'user_id', 'sum', 'id_s'];

  public $timestamps = true;

  public function user() {
    return User::find($this->user_id);
  }
}
