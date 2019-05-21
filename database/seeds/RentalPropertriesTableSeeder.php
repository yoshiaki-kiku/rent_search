<?php

use Illuminate\Database\Seeder;

class RentalPropertriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\RentalProperty::class, 2750)->create();

        factory(App\Models\RentalProperty::class, 100)->create([
            "age" => 0,
        ]);

        factory(App\Models\RentalProperty::class, 150)->create([
            "age" => 3,
        ]);
    }
}
