<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Link;
use Illuminate\Database\Eloquent\Factories\Factory;

class RuleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'link_id' => Link::factory(),
            'priority' => fake()->numberBetween(0, 100),
            'type' => fake()->randomElement([
                'ip',
                'country',
                'city',
                'platform',
                'browser',
                'device',
            ]),
            'value' => fake()->word,
            'target_url' => fake()->url(),
            'status' => true,
        ];
    }
}
