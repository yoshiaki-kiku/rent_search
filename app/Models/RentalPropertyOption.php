<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalPropertyOption extends Model
{
    public function rentalProperties()
    {
        return $this->belongsToMany('App\Models\RentalProperty', "property_option");
    }

    /**
     * 配列のオプションリストを取得
     *
     * @return void
     */
    public function getOptionArr()
    {
        $options = RentalPropertyOption::all();
        $reval = [];

        foreach ($options as $value) {
            $reval[$value->id] = $value->name;
        }
        return $reval;
    }
}
