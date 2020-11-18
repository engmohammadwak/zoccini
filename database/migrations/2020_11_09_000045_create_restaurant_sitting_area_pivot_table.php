<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantSittingAreaPivotTable extends Migration
{
    public function up()
    {
        Schema::create('restaurant_sitting_area', function (Blueprint $table) {
            $table->unsignedInteger('restaurant_id');
            $table->foreign('restaurant_id', 'restaurant_id_fk_2438963')->references('id')->on('restaurants')->onDelete('cascade');
            $table->unsignedInteger('sitting_area_id');
            $table->foreign('sitting_area_id', 'sitting_area_id_fk_2438963')->references('id')->on('sitting_areas')->onDelete('cascade');
        });
    }
}
