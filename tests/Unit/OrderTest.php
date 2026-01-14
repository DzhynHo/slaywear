<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Order;

class OrderTest extends TestCase
{
    public function test_calculate_total_from_items()
    {
        $items = [
            ['quantity' => 2, 'price' => 10.5],
            ['quantity' => 1, 'price' => 5.25],
        ];

        $total = Order::calculateTotalFromItems($items);
        $this->assertEquals(26.25, $total);
    }
}
