<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->json('name')->change(); // Change 'name' column to JSON
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name')->change(); // Revert back to string if needed
        });
    }
};
