<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add the 'sequency' column to the 'categories' table
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('sequency')->nullable();
        });

        // Separate the SET and UPDATE queries
        DB::statement('SET @row_number = 0');
        DB::statement('
            UPDATE categories
            SET sequency = (@row_number := @row_number + 1)
            ORDER BY id
        ');

        // Make the 'sequency' column non-nullable
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('sequency')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the 'sequency' column from the 'categories' table
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('sequency');
        });
    }
};

