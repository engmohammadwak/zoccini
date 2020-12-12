<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraOrderPivotTable extends Migration
{
    public function up()
    {
        Schema::create('extra_order', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id', 'order_id_fk_2773783')->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedBigInteger('extra_id');
        });
    }
}
