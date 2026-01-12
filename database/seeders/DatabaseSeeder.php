<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Payment;
use App\Models\Review;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tworzymy role
        Role::factory()->create(['name' => 'Administrator']);
        Role::factory()->create(['name' => 'Klient']);
        Role::factory()->create(['name' => 'Pracownik']);

        // Tworzymy testowego użytkownika
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // hasło do logowania
            'role_id' => 1, // np. Administrator
        ]);

        // Tworzymy kilku dodatkowych użytkowników
        User::factory(5)->create();

        // Tworzymy kategorie i produkty
        Category::factory(5)->create();
        Product::factory(20)->create();

        // Tworzymy zamówienia i powiązane elementy
        Order::factory(10)->create();
        OrderItem::factory(30)->create();

        // Tworzymy adresy
        Address::factory(10)->create();

        // Tworzymy płatności
        Payment::factory(10)->create();

        // Tworzymy recenzje
        Review::factory(15)->create();
    }
}
