<?php

namespace App\Models\Classic;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Games extends Model
{
  const STATUS_NOT_STARTED = 0;
  const STATUS_PLAYING = 1;
  const STATUS_PRE_FINISH = 2;
  const STATUS_FINISHED = 3;
  const STATUS_ERROR = 4;

  protected $table = 'games_classic';

  protected $fillable = ['random', 'signature', 'number'];

  public $timestamps = true;
}
