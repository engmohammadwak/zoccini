<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToItemsTable extends Migration
{
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedInteger('restaurant_id')->nullable();
            $table->foreign('restaurant_id', 'restaurant_fk_2438947')->references('id')->on('restaurants');
            $table->unsignedInteger('category_id')->nullable();
            $table->foreign('category_id', 'category_fk_2438948')->references('id')->on('categories');
        });
    }
}
