<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentalArea;
use App\Models\RentalFloorPlans;

class RentSearchController extends Controller
{
    public function index()
    {
        $rentalAreas = RentalArea::all();
        $rentalFloorPlans = RentalFloorPlans::all();

        return view("index", [
            "rentalAreas" => $rentalAreas,
            "rentalFloorPlans" => $rentalFloorPlans,
        ]);
    }
}
