<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalProperty extends Model
{
    public function RentalPropertyOptions()
    {
        return $this->belongsToMany('App\Models\RentalPropertyOption', "property_option");
    }
}
