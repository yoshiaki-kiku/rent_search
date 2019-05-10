<?php

use Illuminate\Database\Seeder;
use App\Models\RentalArea;

class RentalAreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = [
            "札幌市中央区",
            "札幌市北区",
            "札幌市東区",
            "札幌市白石区",
            "札幌市豊平区",
            "札幌市南区",
            "札幌市西区",
            "札幌市厚別区",
            "札幌市手稲区",
            "札幌市清田区",
        ];

        foreach ($areas as $value) {
            RentalArea::create([
                "area_name" => $value,
            ]);
        }
    }
}
