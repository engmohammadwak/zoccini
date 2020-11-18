<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('q_ar');
            $table->string('a_ar');
            $table->string('q_en');
            $table->string('a_en');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
