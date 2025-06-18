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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('payment_type');// Cash, Transfer, Gopay, QRIS, Dana dll
            $table->string('transaction_id')->nullable(); // ID dari Midtrans
            $table->string('status'); // pending, settlement, expired, etc.
            $table->decimal('total_amount', 10, 2);
            $table->json('response')->nullable(); // simpan response json Midtrans
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
