<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('value');
            $table->string('status');
            $table->string('maximum_usage');
            $table->date('start_day');
            $table->date('end_day');
            $table->string('type');
            $table->string('number_used')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
