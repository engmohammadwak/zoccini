<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToRatesTable extends Migration
{
    public function up()
    {
        Schema::table('rates', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_2439014')->references('id')->on('users');
            $table->unsignedInteger('restaurant_id')->nullable();
            $table->foreign('restaurant_id', 'restaurant_fk_2439015')->references('id')->on('users');
        });
    }
}
