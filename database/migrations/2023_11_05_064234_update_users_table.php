<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_type_id');
            $table->unsignedBigInteger('user_product_id')->nullable();
            $table->foreign('user_product_id')->references('id')->on('products');
            $table->foreign('user_type_id')->references('id')->on('users_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('users');
    }
};
