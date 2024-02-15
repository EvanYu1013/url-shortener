<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory
{
    public function definition(): array
    {
        $validFrom = fake()->dateTimeBetween('-1 month', '+1 month');
        $validUntil = fake()->dateTimeBetween($validFrom, '+1 months');

        return [
            'tenant_id' => Tenant::factory(),
            'slug' => fake()->unique()->slug,
            'target_url' => fake()->url,
            'valid_from' => $validFrom,
            'valid_until' => $validUntil,
            'status' => fake()->boolean,
        ];
    }
}
