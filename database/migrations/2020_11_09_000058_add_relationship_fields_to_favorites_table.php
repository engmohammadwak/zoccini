<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFavoritesTable extends Migration
{
    public function up()
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_2554574')->references('id')->on('users');
            $table->unsignedInteger('item_id')->nullable();
            $table->foreign('item_id', 'item_fk_2554576')->references('id')->on('items');
            $table->unsignedInteger('restaurant_id')->nullable();
            $table->foreign('restaurant_id', 'restaurant_fk_2554577')->references('id')->on('restaurants');
        });
    }
}
