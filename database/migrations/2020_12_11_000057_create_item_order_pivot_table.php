<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemOrderPivotTable extends Migration
{
    public function up()
    {
        Schema::create('item_order', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id', 'order_id_fk_2554545')->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedBigInteger('item_id');
        });
    }
}
