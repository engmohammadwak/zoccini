<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedInteger('restaurant_id');
            $table->foreign('restaurant_id', 'restaurant_fk_2554378')->references('id')->on('restaurants');
        });
    }
}
