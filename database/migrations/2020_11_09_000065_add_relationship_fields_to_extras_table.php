<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToExtrasTable extends Migration
{
    public function up()
    {
        Schema::table('extras', function (Blueprint $table) {
            $table->unsignedInteger('item_id');
            $table->foreign('item_id', 'item_fk_2554429')->references('id')->on('items');
        });
    }
}
