<?php

use Illuminate\Database\Seeder;
use App\Models\RentalFloorPlans;

class RentalFloorPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $floorPlans = [
            "1K",
            "1DK",
            "1LDK",
            "2K",
            "2DK",
            "2LDK",
            "3K",
            "3DK",
            "3LDK",
            "4K",
            "4DK",
            "4LDK",
        ];

        foreach ($floorPlans as $value) {
            RentalFloorPlans::create([
                "floor_plan_name" => $value,
            ]);
        }
    }
}
