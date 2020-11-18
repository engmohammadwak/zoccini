<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSubscriptionVipsTable extends Migration
{
    public function up()
    {
        Schema::table('subscription_vips', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_2554864')->references('id')->on('users');
        });
    }
}
