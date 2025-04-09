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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clint_id');
            $table->foreign('clint_id')->references('id')->on('clints')->onDelete('cascade');
            $table->decimal('total', 8, 2);
            $table->decimal('tax', 8, 2)->default(0.0);
            $table->decimal('discount', 8, 2)->default(0.0);
            $table->string('payment_method')->nullable();
            $table->decimal('cash', 8, 2)->nullable();
            $table->decimal('card', 8, 2)->nullable();
            $table->decimal('rest', 8, 2)->nullable();
            $table->decimal('refund', 8, 2)->nullable();
            $table->enum('refund_status', ['full', 'partial'])->nullable();
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
