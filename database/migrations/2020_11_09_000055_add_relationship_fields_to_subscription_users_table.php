<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSubscriptionUsersTable extends Migration
{
    public function up()
    {
        Schema::table('subscription_users', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_2555059')->references('id')->on('users');
            $table->unsignedInteger('package_id');
            $table->foreign('package_id', 'package_fk_2555063')->references('id')->on('subscription_packages');
        });
    }
}
