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

        // Tworzymy testowego administratora
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id,
        ]);

        // Tworzymy testowego klienta
        $clientUser = User::factory()->create([
            'name' => 'Client User',
            'email' => 'client@example.com',
            'password' => bcrypt('password'),
            'role_id' => $clientRole->id,
        ]);

        // Tworzymy pracownika
        User::factory()->create([
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'password' => bcrypt('password'),
            'role_id' => $employeeRole->id,
        ]);

        // Tworzymy kilka dodatkowych klientów
        User::factory(5)->create(['role_id' => $clientRole->id]);

        // Tworzymy kategorie i produkty
        $categories = Category::factory(5)->create();
        $products = Product::factory(20)->create([
            'category_id' => $categories->random()->id,
        ]);

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
