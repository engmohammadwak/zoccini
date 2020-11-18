<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToRestaurantsTable extends Migration
{
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->unsignedInteger('delivery_id')->nullable();
            $table->foreign('delivery_id', 'delivery_fk_2438902')->references('id')->on('deliveries');
            $table->unsignedInteger('restaurant_id')->nullable();
            $table->foreign('restaurant_id', 'restaurant_fk_2538759')->references('id')->on('users');
            $table->unsignedInteger('country_id')->nullable();
            $table->foreign('country_id', 'country_fk_2538793')->references('id')->on('countries');
            $table->unsignedInteger('city_id')->nullable();
            $table->foreign('city_id', 'city_fk_2538794')->references('id')->on('cities');
        });
    }
}
