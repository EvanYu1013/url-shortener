<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RequestLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'link_id' => \App\Models\Link::factory(),
            'ip' => fake()->ipv4,
            'user_agent' => fake()->userAgent,
            'platform' => fake()->randomElement(['Windows', 'macOS', 'Linux', 'iOS', 'Android']),
            'browser' => fake()->randomElement(['Chrome', 'Firefox', 'Safari', 'Edge', 'Opera']),
            'device' => fake()->randomElement(['Desktop', 'Mobile', 'Tablet']),
            'country' => fake()->country,
            'city' => fake()->city,
            'latitude' => fake()->latitude,
            'longitude' => fake()->longitude,
            'language' => fake()->languageCode,
            'fingerprint' => fake()->md5,
            'referer' => fake()->url,
            'meta' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ];
    }
}
