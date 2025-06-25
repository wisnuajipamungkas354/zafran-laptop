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
        Schema::create('laptops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands', 'id')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('model', 100);
            $table->string('processor', 50);
            $table->string('ram', 20);
            $table->string('storage', 50);
            $table->string('graphics_card', 100)->nullable();
            $table->string('screen_size', 20);
            $table->enum('grade', ['a','b','c']);
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->text('description')->nullable();
            $table->json('laptop_images');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptops');
    }
};
