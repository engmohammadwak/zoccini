<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSaveCreditCardsTable extends Migration
{
    public function up()
    {
        Schema::table('save_credit_cards', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_2439068')->references('id')->on('users');
        });
    }
}
