<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class MiscLogicTest extends TestCase
{
    public function test_simple_math_assertion()
    {
        $this->assertEquals(4, 2 + 2);
    }

    public function test_string_operations()
    {
        $s = 'SlayWear';
        $this->assertStringStartsWith('Slay', $s);
    }
}
