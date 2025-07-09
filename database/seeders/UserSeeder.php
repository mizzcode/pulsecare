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
            'phone' => '081286558895',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'dr. Al, Sp. KJ',
            'email' => 'al@gmail.com',
            'password' => 'password',
            'role_id' => 2,
            'phone' => '08885975765',
            'photo' => 'cewek_1.png',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'dr. El, Sp. KJ',
            'email' => 'el@gmail.com',
            'password' => 'password',
            'role_id' => 2,
            'phone' => '089525256091',
            'photo' => 'cewek_2.png',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'dr. Jen, Sp. KJ',
            'email' => 'jen@gmail.com',
            'password' => 'password',
            'role_id' => 2,
            'phone' => '08978067321',
            'photo' => 'cewek_3.png',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'misbah',
            'email' => 'misbah@gmail.com',
            'password' => 'password',
            'role_id' => 3,
            'phone' => '081286558895',
            'email_verified_at' => now(),
        ]);
    }
}