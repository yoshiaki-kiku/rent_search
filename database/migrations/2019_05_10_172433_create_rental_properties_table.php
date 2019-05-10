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
            $table->string('adress');     // 住所
            $table->string('area');       // 地域
            $table->integer('rent');      // 賃料
            $table->string('floor_plan'); // 間取り
            $table->integer('age');       // 築年数
            $table->timestamps();
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
