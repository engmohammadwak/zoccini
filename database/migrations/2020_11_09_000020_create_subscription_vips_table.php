<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionVipsTable extends Migration
{
    public function up()
    {
        Schema::create('subscription_vips', function (Blueprint $table) {
            $table->increments('id');
            $table->date('start_day')->nullable();
            $table->date('end_day')->nullable();
            $table->string('status')->nullable();
            $table->string('price')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
