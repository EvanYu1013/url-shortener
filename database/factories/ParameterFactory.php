<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Link;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParameterFactory extends Factory
{
    public function definition(): array
    {
        return [
            'link_id' => Link::factory(),
            'key' => fake()->word,
            'value' => fake()->word,
        ];
    }
}
