<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportingsTable extends Migration
{
    public function up()
    {
        Schema::create('reportings', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('message')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
