<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatesTable extends Migration
{
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rating')->nullable();
            $table->string('rate_1')->nullable();
            $table->string('rate_2')->nullable();
            $table->string('rate_3')->nullable();
            $table->string('rate_4')->nullable();
            $table->longText('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
