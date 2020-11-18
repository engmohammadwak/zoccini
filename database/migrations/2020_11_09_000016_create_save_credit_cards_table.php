<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaveCreditCardsTable extends Migration
{
    public function up()
    {
        Schema::create('save_credit_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('card_number')->nullable();
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->string('cvc')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
