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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->text('description')->nullable()->default(NULL);
            $table->decimal('price', 10, 2)->unsigned();
            $table->integer('stock_quantity')->unsigned();
            $table->boolean('is_active')->default(true);
            $table->float('rate')->nullable()->default(NULL);
            $table->string('opinion')->nullable()->default(NULL);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
