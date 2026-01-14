<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    public function test_formatted_price_and_stock()
    {
        $p = new Product(['price' => 123.45, 'stock' => 2]);
        $this->assertEquals('123,45 zł', $p->formattedPrice());
        $this->assertTrue($p->isInStock());

        $p->stock = 0;
        $this->assertFalse($p->isInStock());
    }
}
