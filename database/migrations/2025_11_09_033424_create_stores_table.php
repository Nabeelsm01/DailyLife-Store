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
            $table->id()->primary();
            $table->string('name_prd');
            $table->text('detail_prd');
            $table->string('category_prd');
            $table->string('img_prd');
            $table->integer('price_prd');
            $table->string('promotion_type')->nullable();
            $table->integer('promotion_value')->nullable();
            $table->integer('stock_prd')->default(0); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->timestamps();
        });

    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('reviews');
    }
};
