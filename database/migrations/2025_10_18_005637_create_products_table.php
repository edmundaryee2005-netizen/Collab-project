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

            // Link to user (who uploaded the product)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Link to category (like Vehicle, Electronics, etc.)
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // Product details
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->boolean('negotiable')->default(false);
            $table->string('market_price_range')->nullable(); // e.g. GH₵ 90K - 95K
            $table->string('image')->nullable();

            $table->timestamps();
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
