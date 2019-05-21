<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use App\Models\RentalProperty;

class RentSearchResultTest extends TestCase
{
    // DBを初期化したい時にtrueにする
    public $initDB = false;

    // 1回だけ初期化を許可する
    private static $isSetup = false;

    public function setUp(): void
    {
        parent::setUp();

        if ($this->initDB == true && self::$isSetup == false) {
            Artisan::call('migrate:refresh');
            $this->seed('RentalAreasTableSeeder');
            $this->seed('RentalFloorPlansTableSeeder');
            $this->rentalProperty = factory(RentalProperty::class, 5)->create();
            $this->seed('RentalPropertyOptionsTableSeeder');
            $this->seed('PropertyOptionTableSeeder');

            self::$isSetup = true;
        }
    }


    public function test_getNormalSearchResult()
    {
        $response = $this->call("GET", route("search.result"), [
            "area" => [1],
        ]);

        $response->assertStatus(200);
    }

    public function test_getRedirectWhenNoAreaSelection()
    {
        $response = $this->call("GET", route("search.result"), []);
        $response->assertStatus(302);
    }

    public function test_assertSeeResult()
    {
        $response = $this->call("GET", route("search.result"), [
            "area" => [1],
        ]);
        $response->assertSee("検索結果");
    }

    public function test_getNormalSearchResultWhenAllSectionSelection()
    {
        $response = $this->call("GET", route("search.result"), [
            "area" => [1, 2],
            "rent_lower_limit" => 30000,
            "rent_upper_limit" => 100000,
            "floor_plan" => [1],
            "age" => 0,
            "option" => [2, 3],
        ]);

        $response->assertStatus(200);
    }

    public function test_assertViewHasAll()
    {
        $response = $this->call("GET", route("search.result"), [
            "area" => [1, 2],
            "rent_lower_limit" => 30000,
            "rent_upper_limit" => 100000,
            "floor_plan" => [1],
            "age" => 0,
            "option" => [2, 3],
        ]);

        $response->assertViewHasAll([
            "properties",
            "optionList",
            "propertyCount",
            "query",
        ]);
    }
}
