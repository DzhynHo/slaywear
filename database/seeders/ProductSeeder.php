<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'T-shirt SLAY',
            'description' => 'Czarny t-shirt z logo SLAYWEAR',
            'price' => 99,
            'stock' => 20,
            'category_id' => 1
        ]);

        Product::create([
            'name' => 'Bluza SLAY',
            'description' => 'Bluza z kapturem, kolor szary',
            'price' => 199,
            'stock' => 15,
            'category_id' => 1
        ]);

        Product::create([
            'name' => 'Spodnie SLAY',
            'description' => 'Czarne spodnie dresowe',
            'price' => 149,
            'stock' => 10,
            'category_id' => 1
        ]);
    }
    

}
