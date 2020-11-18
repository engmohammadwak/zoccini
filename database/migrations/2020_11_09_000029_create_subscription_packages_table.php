<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPackagesTable extends Migration
{
    public function up()
    {
        Schema::create('subscription_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('description');
            $table->string('price');
            $table->string('duration');
            $table->string('number_branches');
            $table->string('file_size');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
