<?php

namespace App\Models\Bot;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bot\Inventory
 *
 * @property integer $bot_id
 * @property integer $item_id
 * @property string $market_name
 * @property string $name
 * @property string $img
 * @property float $price
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bot\Inventory whereBotId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bot\Inventory whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bot\Inventory whereMarketName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bot\Inventory whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bot\Inventory whereImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bot\Inventory wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bot\Inventory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bot\Inventory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Inventory extends Model
{

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'bot_inventories';

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'item_id';
}
