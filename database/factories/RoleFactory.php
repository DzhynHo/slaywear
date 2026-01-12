<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Role;

class RoleFactory extends Factory
{
    protected $model = Role::class; // <- wskazujemy istniejący model

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement(['Administrator', 'Klient', 'Pracownik']),
        ];
    }
}
