<?php

namespace App\Http\Controllers;

use App\Models\RentalArea;
use App\Models\RentalFloorPlan;
use App\Models\RentalPropertyOption;
use App\Models\RentalProperty;
use App\Http\Requests\RentSearch;
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
     * 非同期、検索条件による物件数の取得
     *
     * @param PropertyCount $request
     * @return void
     */
    public function propertyCount(RentSearch $request)
    {
        Log::debug($request);

        $rentalPropertyModel = new RentalProperty();
        $query = $rentalPropertyModel->getPropertyQueryBuild($request);

        // 条件による物件数
        $count = $query->count();
        // 現在条件の各オプションに該当する物件数
        $optionCounts = $rentalPropertyModel->getOptionCount($query);

        return [
            "propertyCount" => $count,
            "optionCounts" => $optionCounts
        ];
    }
}
