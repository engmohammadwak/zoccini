<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('restaurants_id');
            $table->foreign('restaurants_id', 'restaurants_fk_2554416')->references('id')->on('restaurants');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_2554417')->references('id')->on('users');
            $table->unsignedInteger('type_id');
            $table->foreign('type_id', 'type_fk_2554436')->references('id')->on('order_types');
            $table->unsignedInteger('sitting_area_id')->nullable();
            $table->foreign('sitting_area_id', 'sitting_area_fk_2554437')->references('id')->on('sitting_areas');
            $table->unsignedInteger('delivery_company_id')->nullable();
            $table->foreign('delivery_company_id', 'delivery_company_fk_2554446')->references('id')->on('delivery_companies');
            $table->unsignedInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_2554453')->references('id')->on('order_statuses');
            $table->unsignedInteger('cansel_reason_id')->nullable();
            $table->foreign('cansel_reason_id', 'cansel_reason_fk_2554572')->references('id')->on('cansel_reasons');
            $table->unsignedInteger('winner_id')->nullable();
            $table->foreign('winner_id', 'winner_fk_2555055')->references('id')->on('all_ads');
        });
    }
}
