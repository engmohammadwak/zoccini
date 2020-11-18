<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTicketsTable extends Migration
{
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_2554741')->references('id')->on('users');
            $table->unsignedInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_2554753')->references('id')->on('ticket_statuses');
        });
    }
}
