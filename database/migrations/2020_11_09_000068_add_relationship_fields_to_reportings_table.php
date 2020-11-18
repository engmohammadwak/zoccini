<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToReportingsTable extends Migration
{
    public function up()
    {
        Schema::table('reportings', function (Blueprint $table) {
            $table->unsignedInteger('restaurant_id')->nullable();
            $table->foreign('restaurant_id', 'restaurant_fk_2439002')->references('id')->on('users');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_2439004')->references('id')->on('users');
        });
    }
}
