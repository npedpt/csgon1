<?php

namespace App\Models\Cases;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
  protected $table = 'cases';

  protected $fillable = ['name', 'price'];

  public $timestamps = false;
}
