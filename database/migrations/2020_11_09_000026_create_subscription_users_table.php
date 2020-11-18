<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionUsersTable extends Migration
{
    public function up()
    {
        Schema::create('subscription_users', function (Blueprint $table) {
            $table->increments('id');
            $table->date('start_date');
            $table->date('end_day');
            $table->string('price')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
