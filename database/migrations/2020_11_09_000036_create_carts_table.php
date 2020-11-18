<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('quantity')->nullable();
            $table->longText('extra_json')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
