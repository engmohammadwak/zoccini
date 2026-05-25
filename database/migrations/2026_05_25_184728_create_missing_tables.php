<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. category_top_restaurants
        Schema::create('category_top_restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. top_restaurants
        Schema::create('top_restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('category_top_restaurants')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // 3. sliders
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 4. venture_companies
        Schema::create('venture_companies', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('top_restaurants');
        Schema::dropIfExists('category_top_restaurants');
        Schema::dropIfExists('sliders');
        Schema::dropIfExists('venture_companies');
    }
};