<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('message')->nullable();
            $table->string('rate')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
