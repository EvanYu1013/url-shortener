<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ScriptFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word,
            'content' => fake()->text,
            'priority' => fake()->numberBetween(0, 100),
            'status' => fake()->boolean,
        ];
    }
}
