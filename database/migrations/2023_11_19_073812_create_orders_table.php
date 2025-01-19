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
            
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->bigInteger('sub_total')->nullable();
            $table->bigInteger('discount')->nullable();
            $table->bigInteger('total')->nullable();
            $table->string('payment_method')->nullable();
            $table->bigInteger('paid')->nullable();
            $table->bigInteger('due')->nullable();
            $table->bigInteger('profit')->nullable();
            $table->enum('status', ['PAID', 'DUE', 'UNPAID',  'PENDING', 'REFUND'])->default('UNPAID');
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
