<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOtherbranchesTable extends Migration
{
    public function up()
    {
        Schema::table('otherbranches', function (Blueprint $table) {
            $table->unsignedInteger('restaurants_id');
            $table->foreign('restaurants_id', 'restaurants_fk_2554553')->references('id')->on('restaurants');
        });
    }
}
