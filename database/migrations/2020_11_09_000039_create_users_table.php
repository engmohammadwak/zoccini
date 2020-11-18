<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->datetime('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('user_type')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('code')->nullable();
            $table->string('fcm_token')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('sms_subscription')->nullable();
            $table->string('email_subscription')->nullable();
            $table->string('vip')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
