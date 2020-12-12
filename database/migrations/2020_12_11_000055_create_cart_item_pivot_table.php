<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemPivotTable extends Migration
{
    public function up()
    {
        Schema::create('cart_item', function (Blueprint $table) {
            $table->unsignedBigInteger('cart_id');
            $table->foreign('cart_id', 'cart_id_fk_2773781')->references('id')->on('carts')->onDelete('cascade');
            $table->unsignedBigInteger('item_id');
        });
    }
}
