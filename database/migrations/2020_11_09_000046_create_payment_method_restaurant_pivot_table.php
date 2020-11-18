<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodRestaurantPivotTable extends Migration
{
    public function up()
    {
        Schema::create('payment_method_restaurant', function (Blueprint $table) {
            $table->unsignedInteger('restaurant_id');
            $table->foreign('restaurant_id', 'restaurant_id_fk_2438903')->references('id')->on('restaurants')->onDelete('cascade');
            $table->unsignedInteger('payment_method_id');
            $table->foreign('payment_method_id', 'payment_method_id_fk_2438903')->references('id')->on('payment_methods')->onDelete('cascade');
        });
    }
}
