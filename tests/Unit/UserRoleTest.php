<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Models\Role;

class UserRoleTest extends TestCase
{
    public function test_has_role()
    {
        $role = new Role(['name' => 'Administrator']);
        $user = new User();
        $user->setRelation('role', $role);

        $this->assertTrue($user->hasRole('Administrator'));
        $this->assertFalse($user->hasRole('Klient'));
    }
}
