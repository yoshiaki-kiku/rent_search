<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentalArea;
use App\Models\RentalFloorPlan;
use App\Models\RentalPropertyOption;
use App\Models\RentalProperty;

class RentSearchController extends Controller
{
    public function index()
    {
        // フォーム作成時の項目に利用
        $rentalAreas = RentalArea::all();
        $rentalFloorPlans = RentalFloorPlan::all();
        $rentalPropertyOptions = RentalPropertyOption::all();

        $rentalPropertyModel = new RentalProperty();

        // 地域ごとの物件数の取得
        $areaPropertyCount = $rentalPropertyModel->getAreaPropertyCount();

        return view("index", [
            "rentalAreas" => $rentalAreas,
            "rentalFloorPlans" => $rentalFloorPlans,
            "rentalPropertyOptions" => $rentalPropertyOptions,
            "areaPropertyCount" => $areaPropertyCount,
        ]);
    }
}
