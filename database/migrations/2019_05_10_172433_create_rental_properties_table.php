<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('adress');                  // 住所
            $table->unsignedBigInteger('area');        // 地域
            $table->integer('rent');                   // 賃料
            $table->unsignedBigInteger('floor_plan');  // 間取り
            $table->integer('age');                    // 築年数
            $table->timestamps();

            // 地域は外部キーで制約
            $table->foreign('area')
                ->references('id')
                ->on('rental_areas');

            // 間取りは外部キーで制約
            $table->foreign('floor_plan')
                ->references('id')
                ->on('rental_floor_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rental_properties');
    }
}
