<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTablesTable extends Migration
{
    public function up()
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->unsignedInteger('sitting_area_id');
            $table->foreign('sitting_area_id', 'sitting_area_fk_2555037')->references('id')->on('sitting_areas');
            $table->unsignedInteger('status_id');
            $table->foreign('status_id', 'status_fk_2555048')->references('id')->on('table_statuses');
        });
    }
}
