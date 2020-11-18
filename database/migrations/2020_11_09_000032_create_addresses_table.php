<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nice_name')->nullable();
            $table->string('area')->nullable();
            $table->string('street')->nullable();
            $table->string('building')->nullable();
            $table->string('floor')->nullable();
            $table->string('apartment_no')->nullable();
            $table->string('additional_direction')->nullable();
            $table->string('landing_number')->nullable();
            $table->string('phone')->nullable();
            $table->string('lat')->nullable();
            $table->string('lang')->nullable();
            $table->string('main_address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
