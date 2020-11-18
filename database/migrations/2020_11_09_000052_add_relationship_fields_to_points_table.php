<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPointsTable extends Migration
{
    public function up()
    {
        Schema::table('points', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_2554874')->references('id')->on('users');
            $table->unsignedInteger('type_id')->nullable();
            $table->foreign('type_id', 'type_fk_2554933')->references('id')->on('point_types');
        });
    }
}
