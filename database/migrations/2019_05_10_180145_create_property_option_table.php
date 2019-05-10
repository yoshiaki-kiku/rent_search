<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_option', function (Blueprint $table) {
            $table->unsignedBigInteger('rental_property_id');
            $table->unsignedBigInteger('rental_property_option_id');
            // 複合主キー
            // 自動生成だとキー名が長くなるのでnameで指定
            $table->primary(['rental_property_id', 'rental_property_option_id'])
                ->name("propertyid_optionid_primary");

            // 外部キー
            // onDeleteで制約ありのレコードが削除された該当データも自動削除
            $table->foreign('rental_property_id')
                ->references('id')
                ->on('rental_properties')
                ->onDelete('cascade');

            $table->foreign('rental_property_option_id')
                ->references('id')
                ->on('rental_property_options')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_option');
    }
}
