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

    /**
     * 賃貸検索の結果を表示
     *
     * @param RentSearch $request
     * @return void
     */
    public function searchResult(RentSearch $request)
    {
        $rentalPropertyOption = new RentalPropertyOption();
        $optionList = $rentalPropertyOption->getOptionArr();

        $rentalPropertyModel = new RentalProperty();
        $query = $rentalPropertyModel->getPropertyQueryBuild($request);
        $query = $query->with(["rentalArea", "rentalFloorPlan"]);
        $propertyCount = $query->count();
        $properties = $query->paginate(config("rentsearch.paginationNum"));

        return view("search_result", [
            "properties" => $properties,
            "optionList" => $optionList,
            "propertyCount" => $propertyCount,
            "query" => $request->query(),
        ]);
    }
}
