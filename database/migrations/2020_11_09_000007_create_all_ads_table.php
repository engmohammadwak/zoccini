<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllAdsTable extends Migration
{
    public function up()
    {
        Schema::create('all_ads', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('description_ar')->nullable();
            $table->longText('description_en')->nullable();
            $table->string('number_requests')->nullable();
            $table->string('voucher_number')->nullable();
            $table->string('discount')->nullable();
            $table->date('withdraw_day')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
