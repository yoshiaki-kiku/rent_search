<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalPropertyOption extends Model
{
    public function RentalProperties()
    {
        return $this->belongsToMany('App\Models\RentalProperty', "property_option");
    }
}
