<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tworzymy testowego użytkownika
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // dodaj hasło
        ]);

        // Wywołujemy seedery dla kategorii i produktów
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
