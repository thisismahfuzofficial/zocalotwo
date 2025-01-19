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
        // Add the 'sequence' column to the 'products' table
        Schema::table('products', function (Blueprint $table) {
            $table->integer('sequence')->nullable();
        });

        // Set the initial row number
        DB::statement('SET @row_number = 0');

        // Populate the 'sequence' column with sequential values
        DB::statement('
            UPDATE products
            SET sequence = (@row_number := @row_number + 1)
            ORDER BY id;
        ');

        // Make the 'sequence' column non-nullable after populating it
        Schema::table('products', function (Blueprint $table) {
            $table->integer('sequence')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the 'sequence' column from the 'products' table
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('sequence');
        });
    }
};

