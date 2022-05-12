<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarbrandsTable extends Migration
{
    public function up()
    {
        Schema::create('carbrands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_ar')->unique();
            $table->string('name_en')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
