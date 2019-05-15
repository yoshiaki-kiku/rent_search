<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalPropertyOption extends Model
{
    public function rentalProperties()
    {
        return $this->belongsToMany('App\Models\RentalProperty', "property_option");
    }
}
