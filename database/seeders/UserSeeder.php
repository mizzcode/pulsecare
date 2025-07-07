<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Mizz',
            'email' => 'mizz@gmail.com',
            'password' => 'password',
            'role_id' => 1,
            'email_verified_at' => now(),
        ]);
        User::factory()->create([
            'name' => 'Jani',
            'email' => 'jani@gmail.com',
            'password' => 'password',
            'role_id' => 2,
            'email_verified_at' => now(),
        ]);
        User::factory()->create([
            'name' => 'Zul',
            'email' => 'zul@gmail.com',
            'password' => 'password',
            'role_id' => 3,
            'email_verified_at' => now(),
        ]);
    }
}