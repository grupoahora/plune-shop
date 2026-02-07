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
            $table->string('name');
            $table->text('description');
            $table->decimal('price_sale', 10, 2);
            $table->string('product_code')->unique();
            $table->boolean('status')->default(1);
            // discount_value is optional, so it can be nullable
            $table->decimal('discount_value', 10, 2)->nullable();
            // discount_type can be 'percentage' or 'fixed'
            $table->enum('discount_type', ['percentage', 'fixed'])->nullable();
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
