<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CrashBet extends Model
{
	protected $table = 'crashbets';
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function game()
    {
        return $this->belongsTo('App\CrashGame');
    }
}
