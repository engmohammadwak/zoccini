<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mins')->nullable();
            $table->string('tag')->nullable();
            $table->string('address')->nullable();
            $table->string('opening_time')->nullable();
            $table->longText('description')->nullable();
            $table->string('lat')->nullable();
            $table->string('lang')->nullable();
            $table->string('number_of_employees')->nullable();
            $table->string('number_branches')->nullable();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('subscription_package')->nullable();
            $table->date('end_date_subscription')->nullable();
            $table->string('agree_terms_of_use')->nullable();
            $table->string('min_price')->nullable();
            $table->string('rating')->nullable();
            $table->string('fast_delivery')->nullable();
            $table->string('number_rate')->nullable();
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->string('min_waiting')->nullable();
            $table->string('max_waiting')->nullable();
            $table->longText('description_ar')->nullable();
            $table->longText('description_en')->nullable();
            $table->string('file_size_used')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
