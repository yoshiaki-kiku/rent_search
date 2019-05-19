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
        factory(App\Models\RentalProperty::class, 3000)->create();
    }
}
