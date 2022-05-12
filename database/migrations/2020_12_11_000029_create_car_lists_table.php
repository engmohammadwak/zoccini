<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarListsTable extends Migration
{
    public function up()
    {
        Schema::create('car_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pate_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
