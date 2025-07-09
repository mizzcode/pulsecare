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
        User::create([
            'name' => 'Mizz',
            'email' => 'mizz@gmail.com',
            'password' => 'password',
            'role_id' => 1,
            'phone' => '6281286558895',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'dr. Al, Sp. KJ',
            'email' => 'al@gmail.com',
            'password' => 'password',
            'role_id' => 2,
            'phone' => '628885975765',
            'photo' => 'photos/cewek_1.png',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'dr. El, Sp. KJ',
            'email' => 'el@gmail.com',
            'password' => 'password',
            'role_id' => 2,
            'phone' => '6289525256091',
            'photo' => 'photos/cewek_2.png',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'dr. Jen, Sp. KJ',
            'email' => 'jen@gmail.com',
            'password' => 'password',
            'role_id' => 2,
            'phone' => '628978067321',
            'photo' => 'photos/cewek_3.png',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'misbah',
            'email' => 'misbah@gmail.com',
            'password' => 'password',
            'role_id' => 3,
            'phone' => '6281286558895',
            'email_verified_at' => now(),
        ]);
    }
}