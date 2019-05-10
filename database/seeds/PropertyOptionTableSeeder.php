<?php

use Illuminate\Database\Seeder;
use App\Models\RentalProperty;
use Faker\Factory as Faker;

/**
 * 賃貸と賃貸オプションの中間テーブルを作成する
 */
class PropertyOptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create("ja_JP");

        // オプションの最大数
        $maxNumberOfOptions = 8;
        // option一覧
        $optionList = collect(range(1, $maxNumberOfOptions));

        $properties = RentalProperty::all();

        foreach ($properties as $property) {
            // オプションを何個設定するかランダム
            $numberOfOptions = $faker->numberBetween(1, $maxNumberOfOptions);
            // 設定するオプションをランダムで選択
            $options = $optionList->random($numberOfOptions)->all();

            // リレーションでオプションを設定する
            // 数字の配列でsyncで設定すると、
            // 中間テーブルに基づいて賃貸オプションが設定される
            $property->RentalPropertyOptions()->sync($options);
        }
    }
}
