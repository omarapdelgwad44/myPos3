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
