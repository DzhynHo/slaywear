<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Koszulki']);
        Category::create(['name' => 'Bluzy']);
        Category::create(['name' => 'Spodnie']);
        Category::create(['name' => 'Koszule']);
        Category::create(['name' => 'Akcesoria']);
        Category::create(['name' => 'Skarpety']);
        Category::create(['name' => 'Płaszcze']);
        Category::create(['name' => 'Dresy']);
        Category::create(['name' => 'Sukienki']);
        Category::create(['name' => 'Kamizelki']);
    }
}
