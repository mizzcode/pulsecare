<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        // Data sesuai dengan UserSeeder yang sudah ada
        // Role ID 1 = Admin, Role ID 2 = Dokter, Role ID 3 = Pasien

        // Doctors from UserSeeder (role_id = 2)
        $doctors = [
            [
                'name' => 'dr. Al, Sp. KJ',
                'email' => 'al@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'phone' => '628885975765',
                'photo' => 'photos/cewek_1.png',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'dr. El, Sp. KJ',
                'email' => 'el@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'phone' => '6289525256091',
                'photo' => 'photos/cewek_2.png',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'dr. Jen, Sp. KJ',
                'email' => 'jen@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'phone' => '628978067321',
                'photo' => 'photos/cewek_3.png',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($doctors as $doctor) {
            User::updateOrCreate(
                ['email' => $doctor['email']],
                $doctor
            );
        }

        // Admin from UserSeeder (role_id = 1)
        User::updateOrCreate(
            ['email' => 'mizz@gmail.com'],
            [
                'name' => 'Mizz',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'phone' => '6281286558895',
                'email_verified_at' => now(),
            ]
        );

        // Patient user example
        User::updateOrCreate(
            ['email' => 'misbah@gmail.com'],
            [
                'name' => 'misbah',
                'password' => Hash::make('password'),
                'role_id' => 3, // Patient role
                'phone' => '6281286558895',
                'email_verified_at' => now(),
            ]
        );
    }
}
