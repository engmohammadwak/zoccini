<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCitiesTable extends Migration
{
    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->unsignedInteger('countries_id')->nullable();
            $table->foreign('countries_id', 'countries_fk_2439113')->references('id')->on('countries');
        });
    }
}
