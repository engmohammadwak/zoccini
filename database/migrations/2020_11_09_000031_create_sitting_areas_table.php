<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSittingAreasTable extends Migration
{
    public function up()
    {
        Schema::create('sitting_areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_ar');
            $table->string('name_en');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
