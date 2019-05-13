<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentalArea;
use App\Models\RentalFloorPlan;
use App\Models\RentalPropertyOption;

class RentSearchController extends Controller
{
    public function index()
    {
        $rentalAreas = RentalArea::all();
        $rentalFloorPlans = RentalFloorPlan::all();
        $rentalPropertyOptions = RentalPropertyOption::all();


        return view("index", [
            "rentalAreas" => $rentalAreas,
            "rentalFloorPlans" => $rentalFloorPlans,
            "rentalPropertyOptions" => $rentalPropertyOptions,
        ]);
    }
}
