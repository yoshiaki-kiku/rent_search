<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalProperty extends Model
{
    public function RentalPropertyOptions()
    {
        return $this->belongsToMany('App\Models\RentalPropertyOption', "property_option");
    }


    /**
     * 地域ごとの物件数を取得する
     * 地域IDがkey、valueが物件数の配列を返す
     *
     * @return array
     */
    public function getAreaPropertyCount()
    {
        $areaPropertyCountArr = [];
        $rentalProperty = RentalProperty::all();
        foreach ($rentalProperty as $value) {
            if (!empty($areaPropertyCountArr[$value->area])) {
                $areaPropertyCountArr[$value->area] += 1;
            } else {
                $areaPropertyCountArr[$value->area] = 1;
            }
        }

        return collect($areaPropertyCountArr);
    }
}
