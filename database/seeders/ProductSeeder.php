<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Notebook Samsung 15',
                'price' => 1200,
                'tags' => json_encode(['notebook', 'oferta', 'tecnologia']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Monitor Samsung 27',
                'price' => 350,
                'tags' => json_encode(['pantalla', 'oferta']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MacBook Pro 16',
                'price' => 1000,
                'tags' => json_encode(['apple', 'accesorio', 'macbook']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MacBook Pro 20',
                'price' => 100,
                'tags' => json_encode(['apple', 'accesorio', 'macbook']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Iphone 14',
                'price' => 100,
                'tags' => json_encode(['apple', 'accesorio', 'iphone']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Iphone 15',
                'price' => 100,
                'tags' => json_encode(['apple', 'accesorio', 'iphone']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Iphone 16',
                'price' => 100,
                'tags' => json_encode(['apple', 'accesorio', 'iphone']),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
