<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 下記の中間テーブルを取得するためのモデル
 * RentalProperty
 * RentalPropertyOption
 */
class PropertyOption extends Model
{
    protected $table = 'property_option';
}
