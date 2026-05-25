<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // settings
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('namesetting')->nullable();
            $table->text('value')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // contacts
        if (!Schema::hasTable('contacts')) {
            Schema::create('contacts', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->text('message')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // become_partners
        if (!Schema::hasTable('become_partners')) {
            Schema::create('become_partners', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->text('message')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // sms_histories
        if (!Schema::hasTable('sms_histories')) {
            Schema::create('sms_histories', function (Blueprint $table) {
                $table->id();
                $table->string('phone')->nullable();
                $table->text('message')->nullable();
                $table->string('status')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // images
        if (!Schema::hasTable('images')) {
            Schema::create('images', function (Blueprint $table) {
                $table->id();
                $table->string('image')->nullable();
                $table->string('imageable_type')->nullable();
                $table->unsignedBigInteger('imageable_id')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // queues (loop_queue)
        if (!Schema::hasTable('loop_queue')) {
            Schema::create('loop_queue', function (Blueprint $table) {
                $table->id();
                $table->string('status')->nullable();
                $table->unsignedBigInteger('restaurant_id')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // loop_banks
        if (!Schema::hasTable('loop_banks')) {
            Schema::create('loop_banks', function (Blueprint $table) {
                $table->id();
                $table->string('bank_name')->nullable();
                $table->string('account_number')->nullable();
                $table->string('iban')->nullable();
                $table->unsignedBigInteger('restaurant_id')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // loop_users
        if (!Schema::hasTable('loop_users')) {
            Schema::create('loop_users', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('restaurant_id')->nullable();
                $table->string('status')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // expenses
        if (!Schema::hasTable('expenses')) {
            Schema::create('expenses', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->decimal('amount', 10, 2)->nullable();
                $table->text('note')->nullable();
                $table->unsignedBigInteger('expense_category_id')->nullable();
                $table->unsignedBigInteger('restaurant_id')->nullable();
                $table->date('expense_date')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // expense_categories
        if (!Schema::hasTable('expense_categories')) {
            Schema::create('expense_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->unsignedBigInteger('restaurant_id')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // incomes
        if (!Schema::hasTable('incomes')) {
            Schema::create('incomes', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->decimal('amount', 10, 2)->nullable();
                $table->text('note')->nullable();
                $table->unsignedBigInteger('income_category_id')->nullable();
                $table->unsignedBigInteger('restaurant_id')->nullable();
                $table->date('income_date')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // income_categories
        if (!Schema::hasTable('income_categories')) {
            Schema::create('income_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->unsignedBigInteger('restaurant_id')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // offer_users
        if (!Schema::hasTable('offer_users')) {
            Schema::create('offer_users', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('restaurant_id')->nullable();
                $table->string('offer_type')->nullable();
                $table->decimal('discount', 5, 2)->nullable();
                $table->date('expired_at')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // referral_subscriptions
        if (!Schema::hasTable('referral_subscriptions')) {
            Schema::create('referral_subscriptions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('restaurant_id')->nullable();
                $table->string('status')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // ticket_messages
        if (!Schema::hasTable('ticket_messages')) {
            Schema::create('ticket_messages', function (Blueprint $table) {
                $table->id();
                $table->text('message')->nullable();
                $table->unsignedBigInteger('ticket_id')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        $tables = [
            'settings', 'contacts', 'become_partners', 'sms_histories',
            'images', 'loop_queue', 'loop_banks', 'loop_users',
            'expenses', 'expense_categories', 'incomes', 'income_categories',
            'offer_users', 'referral_subscriptions', 'ticket_messages',
        ];
        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
};