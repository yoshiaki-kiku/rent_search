<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentalArea;
use App\Models\RentalFloorPlan;
use App\Models\RentalPropertyOption;
use App\Models\RentalProperty;
use App\Http\Requests\PropertyCount;
use Debugbar;
use Illuminate\Support\Facades\Log;

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
     *   'areas' =>
[2019-05-15 15:16:17] local.INFO: array (
  'area' =>
  array (
  ),
  'rent_lower_limit' => NULL,
  'rent_upper_limit' => NULL,
  'floor_plan' =>
  array (
    0 => 7,
  ),
  'age' => NULL,
  'option' =>
  array (
  ),
)

       $table->bigIncrements('id');
            $table->string('adress');                  // 住所
            $table->unsignedBigInteger('area');        // 地域
            $table->integer('rent');                   // 賃料
            $table->unsignedBigInteger('floor_plan');  // 間取り
            $table->integer('age');                    // 築年数
     *
     * @param PropertyCount $request
     * @return void
     */
    public function propertyCount(PropertyCount $request)
    {
        $rentalPropertyModel = new RentalProperty();
        $rentalPropertyModel->getPropertyQueryBuild($request);
        // info($request);

        $a = "デバッグ";
        die(json_encode($request, true));
    }
}
