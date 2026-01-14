<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
         // Zamiast truncate()
        // Product::truncate(); ❌

        // Użyj delete()
        Product::query()->delete(); // ✅ bezpieczne przy FK

        // Upewnij się, że istnieje kategoria domyślna
        $category = \App\Models\Category::firstOrCreate(['name' => 'Domyślna']);

        $items = [
            [
                'name' => 'Jeansy',
                'description' => 'Zwykłe niebieskie jeansy',
                'brand' => 'Slaywear',
                'photo' => '1.jpg',
            ],
            [
                'name' => 'Krawat',
                'description' => 'Czarny krawat z wzorami',
                'brand' => 'Slaywear',
                'photo' => '2.jpg',
            ],
            [
                'name' => 'Kamizelka',
                'description' => 'Kamizelka z motywem smoka',
                'brand' => 'Slaywear',
                'photo' => '3.jpg',
            ],
            [
                'name' => 'Koszulka',
                'description' => 'Czarna koszulka z królikem',
                'brand' => 'Slaywear',
                'photo' => '4.jpg',
            ],
            [
                'name' => 'Koszulka',
                'description' => 'Czarna koszulka z nadrukiem Sonica',
                'brand' => 'Slaywear',
                'photo' => '5.jpg',
            ],
            [
                'name' => 'Bluza',
                'description' => 'Bluza z motywem Roblox',
                'brand' => 'Slaywear',
                'photo' => '6.jpg',
            ],
            [
                'name' => 'Skarpetki',
                'description' => 'Białe skarpetki, nazwa 52',
                'brand' => 'Slaywear',
                'photo' => '7.jpg',
            ],
            [
                'name' => 'Koszulka',
                'description' => 'Biała koszulka z logo marki',
                'brand' => 'Slaywear',
                'photo' => '8.jpg',
            ],
        ];

        foreach ($items as $data) {
            Product::create([
                'name' => $data['name'],
                'brand' => $data['brand'],
                'description' => $data['description'],
                'price' => 99.00,
                'stock' => 10,
                'category_id' => $category->id,
                'photo' => $data['photo'],
            ]);
        }
    }
    

}
