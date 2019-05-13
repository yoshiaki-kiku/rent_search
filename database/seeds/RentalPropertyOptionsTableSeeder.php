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
        ];

        foreach ($options as $value) {
            RentalPropertyOption::create([
                "name" => $value,
            ]);
        }
    }
}
