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
            'name' => 'Mizzkun',
            'email' => 'mizz@gmail.com',
            'password' => 'password',
            'role_id' => 1,
            'email_verified_at' => now(),
        ]);
        User::factory()->create([
            'name' => 'Janichan',
            'email' => 'jani@gmail.com',
            'password' => 'password',
            'role_id' => 2,
            'email_verified_at' => now(),
        ]);
    }
}
