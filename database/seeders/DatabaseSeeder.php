<?php

namespace Database\Seeders;

use App\Models\Laptop;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'email' => 'wisnu@gmail.com',
            'password' => 'password',
            'name' => 'Wisnu',
            'role' => 'OWNER',
            'gender' => 'L',
            'address' => 'Klari, Karawang',
            'phone_number' => '085889634432',
            'is_active' => true,
        ]);
    }
}
