<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCountriesTable extends Migration
{
    public function up()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->unsignedInteger('currency_id')->nullable();
            $table->foreign('currency_id', 'currency_fk_2439126')->references('id')->on('currencies');
        });
    }
}
