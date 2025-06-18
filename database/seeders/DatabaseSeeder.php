<?php

namespace Database\Seeders;

use App\Models\Brand;
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
            'gender' => 'L',
            'address' => 'Klari, Karawang',
            'phone_number' => '085889634432',
            'is_active' => true,
        ]);

        $brand = ['ASUS', 'ACER', 'LENOVO', 'HP', 'DELL', 'AXIOO', 'ADVAN', 'INFINIX', 'SAMSUNG', 'TOSHIBA'];

        foreach($brand as $b) {
            Brand::create([
                'brand_name' => $b,
            ]);
        }

        $laptops = [
            [
                'brand_id' => 1,
                'model' => 'Vivobook X441N',
                'processor' => 'Intel Celeron N4002',
                'ram' => '4GB',
                'storage' => '256GB SSD',
                'screen_size' => '14 Inch',
                'condition' => 'Bekas',
                'price' => 1800000,
                'stock' => 13,
                'description' => 'No Minus',
                'user_id' => 1,
            ]
        ];
    }    
}
