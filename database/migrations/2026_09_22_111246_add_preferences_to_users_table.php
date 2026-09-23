<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->integer('age')->nullable();
            $table->string('spicy_level')->nullable();
            $table->string('dietary_preferences')->nullable();
            $table->string('preferred_taste')->nullable();
            $table->decimal('price_preference', 8, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 
                'age', 
                'spicy_level', 
                'dietary_preferences', 
                'preferred_taste', 
                'price_preference'
            ]);
        });
    }
};