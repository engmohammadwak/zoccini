<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartExtraPivotTable extends Migration
{
    public function up()
    {
        Schema::create('cart_extra', function (Blueprint $table) {
            $table->unsignedBigInteger('cart_id');
            $table->foreign('cart_id', 'cart_id_fk_2773782')->references('id')->on('carts')->onDelete('cascade');
            $table->unsignedBigInteger('extra_id');
        });
    }
}
