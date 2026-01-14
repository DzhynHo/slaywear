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
        $adminRole = Role::factory()->create(['name' => 'Administrator']);
        $clientRole = Role::factory()->create(['name' => 'Klient']);
        $employeeRole = Role::factory()->create(['name' => 'Pracownik']);

        // Tworzymy (jeśli nie istnieją) konta testowe: administrator, klient, pracownik
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'role_id' => $adminRole->id,
            ]
        );

        $clientUser = User::firstOrCreate(
            ['email' => 'client@example.com'],
            [
                'name' => 'Client User',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'role_id' => $clientRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'employee@example.com'],
            [
                'name' => 'Employee User',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'role_id' => $employeeRole->id,
            ]
        );

        // Tworzymy kilka dodatkowych klientów
        User::factory(5)->create(['role_id' => $clientRole->id]);

        // Tworzymy kategorie i produkty z predefiniowanego seeda
        $this->call(\Database\Seeders\CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $products = Product::all();

        // Tworzymy adresy dla klientów
        Address::factory(10)->create([
            'user_id' => $clientUser->id,
        ]);

        // Tworzymy zamówienia dla klienta
        $orders = Order::factory(5)->create([
            'user_id' => $clientUser->id,
            'status' => 'pending',
            'total_price' => 0, // będzie obliczone po dodaniu elementów
        ]);

        // Tworzymy elementy zamówień
        foreach ($orders as $order) {
            $items = OrderItem::factory(rand(1, 5))->create([
                'order_id' => $order->id,
                'product_id' => $products->random()->id,
                'quantity' => rand(1, 3),
                'price' => $products->random()->price,
            ]);

            // Obliczamy łączną cenę zamówienia
            $total = $items->sum(fn($item) => $item->quantity * $item->price);
            $order->update(['total_price' => $total]);
        }

        // Tworzymy płatności dla zamówień
        foreach ($orders as $order) {
            Payment::factory()->create([
                'order_id' => $order->id,
                'amount' => $order->total_price,
                'status' => 'paid',
            ]);
        }

        // Tworzymy recenzje dla produktów
        foreach ($products as $product) {
            Review::factory(rand(0, 3))->create([
                'product_id' => $product->id,
                'user_id' => $clientUser->id,
            ]);
        }
    }
}
