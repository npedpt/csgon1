<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unitpay extends Model
{
  protected $table = 'unitpay_payments';

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'id';

  public $timestamps = false;
}
