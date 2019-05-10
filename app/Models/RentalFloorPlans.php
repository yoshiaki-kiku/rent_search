<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalFloorPlans extends Model
{
    public function RentalProperties()
    {
        return $this->hasMany('App\Models\RentalProperty');
    }
}
