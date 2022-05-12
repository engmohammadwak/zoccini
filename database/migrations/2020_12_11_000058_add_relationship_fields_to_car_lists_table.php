<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCarListsTable extends Migration
{
    public function up()
    {
        Schema::table('car_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('car_brand_id')->nullable();
            $table->foreign('car_brand_id', 'car_brand_fk_2773198')->references('id')->on('carbrands');
            $table->unsignedBigInteger('car_type_id')->nullable();
            $table->foreign('car_type_id', 'car_type_fk_2773199')->references('id')->on('type_of_cars');
            $table->unsignedBigInteger('car_color_id')->nullable();
            $table->foreign('car_color_id', 'car_color_fk_2773200')->references('id')->on('car_colors');
        });
    }
}
