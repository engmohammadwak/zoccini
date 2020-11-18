<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAllAdsTable extends Migration
{
    public function up()
    {
        Schema::table('all_ads', function (Blueprint $table) {
            $table->unsignedInteger('restaurant_id');
            $table->foreign('restaurant_id', 'restaurant_fk_2548757')->references('id')->on('restaurants');
            $table->unsignedInteger('category_id');
            $table->foreign('category_id', 'category_fk_2548762')->references('id')->on('ads_categories');
            $table->unsignedInteger('winner_id')->nullable();
            $table->foreign('winner_id', 'winner_fk_2555054')->references('id')->on('users');
        });
    }
}
