<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use App\Models\RentalProperty;

class PropertyCountTest extends TestCase
{
    // use RefreshDatabase;

    // DBを初期化したい時にtrueにする
    public $initDB = false;

    // 1回だけ初期化を許可する
    private static $isSetup = false;

    public function setUp(): void
    {
        parent::setUp();

        if ($this->initDB == true && self::$isSetup == false) {
            Artisan::call('migrate:refresh');
            Artisan::call('db:seed --class=RentalAreasTableSeeder');
            Artisan::call('db:seed --class=RentalFloorPlansTableSeeder');
            $this->rentalProperty = factory(RentalProperty::class, 5)->create();
            // Artisan::call('db:seed --class=PropertyOptionTableSeeder');
            Artisan::call('db:seed --class=RentalPropertyOptionsTableSeeder');
            self::$isSetup = true;
        }
    }

    public function test_getErrorWhenNoAreaSelection()
    {
        $response = $this->json("POST", route("property.count", [""]));
        $response->assertStatus(422);
    }

    public function test_getOKWhenOnlyAreaSelection()
    {
        $response = $this->json("POST", route("property.count", [
            "area" => [1]
        ]));

        $response->assertStatus(200);
    }

    public function test_returnNormalJSONWhenOnlyAreaSelection()
    {
        $response = $this->json("POST", route("property.count", [
            "area" => [1]
        ]));
        $response->assertStatus(200)->assertJsonStructure([
            // 16のオプション数があれば1-16のキーを返す
            "optionCounts" => [
                "1", "2", "3", "4", "5", "6", "7", "8",
                "9", "10", "11", "12", "13", "14", "15", "16"
            ],
            "propertyCount"
        ]);
    }

    public function test_returnNormalJSONWhenAllSectionSelection()
    {
        $response = $this->json("POST", route("property.count", [
            "area" => [1, 2],
            "rent_lower_limit" => 30000,
            "rent_upper_limit" => 100000,
            "floor_plan" => [1],
            "age" => 0,
            "option" => [2, 3],
        ]));

        $response->assertStatus(200);
    }

    public function test_getErrorWhenRentMaxBreak()
    {
        $response = $this->json("POST", route("property.count", [
            "area" => [1, 2],
            "rent_upper_limit" => 600001,
        ]));

        $response->assertStatus(422);
    }

    public function test_getErrorWhenRentLowerLimitBreak()
    {
        $response = $this->json("POST", route("property.count", [
            "area" => [1, 2],
            "rent_lower_limit" => 29999,
        ]));

        $response->assertStatus(422);
    }
}
