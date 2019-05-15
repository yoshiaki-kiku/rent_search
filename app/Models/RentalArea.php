<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalArea extends Model
{
    public function rentalProperties()
    {
        return $this->hasMany('App\Models\RentalProperty');
    }
}
