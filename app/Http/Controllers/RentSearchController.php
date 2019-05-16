<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentalArea;
use App\Models\RentalFloorPlan;
use App\Models\RentalPropertyOption;
use App\Models\RentalProperty;
use App\Http\Requests\PropertyCount;
use Log;

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

    /**
     * @param PropertyCount $request
     * @return void
     */
    public function propertyCount(PropertyCount $request)
    {
        $rentalPropertyModel = new RentalProperty();
        $query = $rentalPropertyModel->getPropertyQueryBuild($request);

        // 条件による物件数
        $count = $query->count();
        // 現在条件の各オプションに該当する物件数
        $optionCounts = $rentalPropertyModel->getOptionCount($query);

        Log::debug($count);
        Log::debug($optionCounts);

        $a = "デバッグ";
        die(json_encode($request, true));
    }
}
