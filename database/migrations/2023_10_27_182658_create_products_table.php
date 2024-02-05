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
            $table->string('prod_name');
            $table->text('prod_description')->nullable()->default(NULL);
            $table->decimal('prod_price', 10, 2)->unsigned();
            $table->integer('prod_stock_quantity')->unsigned();
            $table->boolean('prod_is_active')->default(true);
            $table->float('prod_rate')->nullable()->default(NULL);
            $table->string('prod_opinion')->nullable()->default(NULL);
            
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
