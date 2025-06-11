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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnUpdate()->cascadeOnDelete(); // Relasi ke users, nullable jika tidak semua customer punya akun login
            $table->string('email')->unique();
            $table->string('password');
            $table->string('first_name', 50);
            $table->string('last_name', 50)->nullable();
            $table->enum('gender', ['L','P']);
            $table->text('address');
            $table->string('phone_number', 20)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
