<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('favorite_categories')->nullable();
            $table->string('favorite_ingredients')->nullable();
            $table->string('disliked_ingredients')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['favorite_categories', 'favorite_ingredients', 'disliked_ingredients']);
        });
    }
};