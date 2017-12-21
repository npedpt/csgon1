<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bot
 *
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property integer $steamid
 * @property string $identity_secret
 * @property string $shared_key
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bot whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bot whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bot whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bot wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bot whereSteamid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bot whereIdentitySecret($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bot whereSharedKey($value)
 * @mixin \Eloquent
 */
class Bot extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bots';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
