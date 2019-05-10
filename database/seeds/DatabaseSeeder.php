<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RentalAreasTableSeeder::class);
        $this->call(RentalFloorPlansTableSeeder::class);
        $this->call(RentalPropertriesTableSeeder::class);
        $this->call(RentalPropertyOptionsTableSeeder::class);
        $this->call(PropertyOptionTableSeeder::class);
    }
}
