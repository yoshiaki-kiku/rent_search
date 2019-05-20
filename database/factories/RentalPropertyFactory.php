<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\RentalProperty;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(RentalProperty::class, function (Faker $faker) {

    $areaArr = [
        "札幌市中央区" => 1,
        "札幌市北区" => 2,
        "札幌市東区" => 3,
        "札幌市白石区" => 4,
        "札幌市豊平区" => 5,
        "札幌市南区" => 6,
        "札幌市西区" => 7,
        "札幌市厚別区" => 8,
        "札幌市手稲区" => 9,
        "札幌市清田区" => 10,
    ];

    // 間取りと適当な賃料相場の上限下限
    // 以下を*1000して賃料とする
    $floorPlanRentArr = [
        "1K" => [30, 40],
        "1DK" => [35, 60],
        "1LDK" => [45, 80],
        "2K" => [45, 80],
        "2DK" => [50, 95],
        "2LDK" => [55, 110],
        "3K" => [55, 110],
        "3DK" => [90, 160],
        "3LDK" => [150, 250],
        "4K" => [150, 300],
        "4DK" => [250, 400],
        "4LDK" => [250, 500],
    ];

    // 間取りのID
    $floorPlanArr = [
        "1K" => 1,
        "1DK" => 2,
        "1LDK" => 3,
        "2K" => 4,
        "2DK" => 5,
        "2LDK" => 6,
        "3K" => 7,
        "3DK" => 8,
        "3LDK" => 9,
        "4K" => 10,
        "4DK" => 11,
        "4LDK" => 12,
    ];

    // 間取り名だけの配列
    $floorPlanNameArr = array_keys($floorPlanRentArr);

    // 間取り決定
    $floorPlanName = $faker->randomElement($floorPlanNameArr);

    // 間取りから賃料のランダム下限上限を決定
    $rent = $faker->numberBetween(
        $floorPlanRentArr[$floorPlanName][0],
        $floorPlanRentArr[$floorPlanName][1]
    );
    $rent = $rent * 1000;

    $date = Carbon::now()->format('Y-m-d H:i:s');

    return [
        'adress' => "北海道札幌市ダミー住所55-55-55",
        "rental_area_id" => $faker->randomElement($areaArr),
        "rent" => $rent,
        "rental_floor_plan_id" => $floorPlanArr[$floorPlanName],
        "age" => $faker->numberBetween(0, 35),
        "created_at" => $date,
        "updated_at" => $date,
    ];
});
