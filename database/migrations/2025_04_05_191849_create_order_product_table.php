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
        Schema::create('order_product', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);    
            $table->decimal('price', 8, 2);
            $table->decimal('total', 8, 2);
            $table->decimal('tax', 8, 2)->default(0.0);
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->string('payment_method')->nullable();
            $table->decimal('cash', 8, 2)->nullable();
            $table->decimal('card', 8, 2)->nullable();
            $table->decimal('rest', 8, 2)->nullable();
            $table->decimal('refund', 8, 2)->nullable();
            $table->enum('refund_status', ['full', 'partial'])->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
