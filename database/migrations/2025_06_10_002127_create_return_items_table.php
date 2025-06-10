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
        Schema::create('return_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('return_id')->constrained('returns')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('laptop_id')->constrained('laptops')->cascadeOnUpdate()->restrictOnDelete();
            $table->integer('quantity');
            $table->decimal('price_at_return', 10, 2);
            $table->string('condition_on_return', 50)->nullable();
            $table->decimal('subtotal_returned', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_items');
    }
};
