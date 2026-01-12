<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Payment;
use App\Models\Order;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'amount' => $this->faker->randomFloat(2, 50, 1000),
            'method' => $this->faker->randomElement(['card','cash','paypal']),
            'status' => $this->faker->randomElement(['paid','pending','failed']),
        ];
    }
}
