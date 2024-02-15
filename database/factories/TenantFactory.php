<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company,
        ];
    }
}
