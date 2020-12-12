<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number_people')->nullable();
            $table->string('schedule_request')->nullable();
            $table->datetime('schedule_date')->nullable();
            $table->string('car_number_yes')->nullable();
            $table->string('delivery')->nullable();
            $table->string('item_json')->nullable();
            $table->longText('cansel_reason_message')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
