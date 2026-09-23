<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('orders', 'payment_status')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('payment_status')->default('unpaid');
            });
        }

        if (!Schema::hasColumn('products', 'preparation_time')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('preparation_time')->nullable();
            });
        }
        if (!Schema::hasColumn('products', 'ingredients')) {
            Schema::table('products', function (Blueprint $table) {
                $table->text('ingredients')->nullable();
            });
        }
        if (!Schema::hasColumn('products', 'status')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('status')->default('available');
            });
        }

        if (!Schema::hasColumn('beverages', 'size')) {
            Schema::table('beverages', function (Blueprint $table) {
                $table->string('size')->nullable();
            });
        }
        if (!Schema::hasColumn('beverages', 'temperature')) {
            Schema::table('beverages', function (Blueprint $table) {
                $table->string('temperature')->nullable();
            });
        }
        if (!Schema::hasColumn('beverages', 'status')) {
            Schema::table('beverages', function (Blueprint $table) {
                $table->string('status')->default('available');
            });
        }

        if (!Schema::hasColumn('users', 'favorite_food_types')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('favorite_food_types')->nullable();
            });
        }
        if (!Schema::hasColumn('users', 'favorite_beverages')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('favorite_beverages')->nullable();
            });
        }
    }

    public function down()
    {
    }
};