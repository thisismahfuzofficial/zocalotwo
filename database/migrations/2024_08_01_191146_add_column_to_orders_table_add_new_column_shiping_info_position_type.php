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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('restaurant_id')->nullable()->constrained()->nullOnDelete();
            $table->json('shipping_info')->nullable();
            $table->text('comment')->nullable();
            $table->text('delivery_option')->nullable();
            $table->json('extra')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('restaurant_id','shipping_info','comment', 'delivery_option', 'extra');
        });
    }
};
