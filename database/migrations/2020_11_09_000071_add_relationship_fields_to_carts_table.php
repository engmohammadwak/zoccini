<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCartsTable extends Migration
{
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_2439026')->references('id')->on('users');
            $table->unsignedInteger('item_id')->nullable();
            $table->foreign('item_id', 'item_fk_2439027')->references('id')->on('items');
            $table->unsignedInteger('restaurant_id')->nullable();
            $table->foreign('restaurant_id', 'restaurant_fk_2554550')->references('id')->on('restaurants');
        });
    }
}
