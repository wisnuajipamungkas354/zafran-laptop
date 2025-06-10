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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained('orders')->cascadeOnUpdate()->cascadeOnDelete(); // Unique karena satu order satu delivery
            $table->foreignId('courier_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete(); // Bisa null jika kurir belum ditetapkan
            $table->dateTime('shipping_date');
            $table->dateTime('delivery_date')->nullable();
            $table->enum('delivery_status', ['pending', 'on_delivery', 'delivered', 'failed'])->default('pending');
            $table->string('tracking_number', 100)->unique()->nullable();
            $table->string('recipient_name', 100);
            $table->text('recipient_address');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
