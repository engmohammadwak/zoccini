<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherbranchesTable extends Migration
{
    public function up()
    {
        Schema::create('otherbranches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('branch_name_ar')->nullable();
            $table->string('branch_name_en')->nullable();
            $table->string('branch_address_ar')->nullable();
            $table->string('branch_address_en')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
