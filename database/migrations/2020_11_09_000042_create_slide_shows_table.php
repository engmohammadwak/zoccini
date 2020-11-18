<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlideShowsTable extends Migration
{
    public function up()
    {
        Schema::create('slide_shows', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->string('video_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
