<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Truncate all tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('tenants')->truncate();
        DB::table('links')->truncate();
        DB::table('scripts')->truncate();
        DB::table('parameters')->truncate();
        DB::table('rules')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Seed the application's database
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => true,
        ]);

        $tenant = Tenant::factory()->create();

        $tenant->users()->attach($user);

        $link = Link::factory()->create([
            'tenant_id' => $tenant->id,
            'slug' => 'test',
            'target_url' => 'https://laravel.com',
            'valid_from' => now(),
            'valid_until' => now()->addMonth(),
            'status' => true,
        ]);

        $link->scripts()->create([
            'name' => 'Test Script',
            'content' => 'console.log("Hello, world!");',
            'priority' => 1,
            'status' => true,
        ]);

        $link->parameters()->create([
            'key' => 'foo',
            'value' => 'bar',
        ]);

        $link->rules()->create([
            'priority' => 1,
            'type' => 'browser',
            'value' => 'Edge',
            'target_url' => 'https://www.microsoft.com',
            'status' => true,
        ]);

        $link->rules()->create([
            'priority' => 2,
            'type' => 'browser',
            'value' => 'Safari',
            'target_url' => 'https://www.apple.com',
            'status' => true,
        ]);

        $link->rules()->create([
            'priority' => 3,
            'type' => 'browser',
            'value' => 'Chrome',
            'target_url' => 'https://www.google.com',
            'status' => true,
        ]);
    }
}
