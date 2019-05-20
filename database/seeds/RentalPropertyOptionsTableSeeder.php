<?php

use Illuminate\Database\Seeder;
use App\Models\RentalPropertyOption;

class RentalPropertyOptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 8オプション
        $options = [
            "バス・トイレ別",
            "2階以上",
            "室内洗濯機置場",
            "エアコン",
            "駐車場あり",
            "南向き",
            "オートロック",
            "都市ガス",
            "タワーマンション",
            "オール電化",
            "エレベーター",
            "防犯カメラ",
            "宅配ボックス",
            "保証人不要",
            "浴室乾燥機",
            "システムキッチン",
        ];

        foreach ($options as $value) {
            RentalPropertyOption::create([
                "name" => $value,
            ]);
        }
    }
}
