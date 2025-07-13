<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DoctorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get doctor role
        $doctorRole = Role::where('name', 'dokter')->first();

        if (!$doctorRole) {
            // Create doctor role if doesn't exist
            $doctorRole = Role::create([
                'name' => 'dokter',
                'description' => 'Dokter role'
            ]);
        }

        // Create test doctor users
        $doctors = [
            [
                'name' => 'Dr. Ahmad Sudrajat',
                'email' => 'dr.ahmad@pulsecare.com',
                'phone' => '081234567890',
                'gender' => 'male',
                'password' => Hash::make('password'),
                'role_id' => $doctorRole->id,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dr. Siti Nurhaliza',
                'email' => 'dr.siti@pulsecare.com',
                'phone' => '081234567891',
                'gender' => 'female',
                'password' => Hash::make('password'),
                'role_id' => $doctorRole->id,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dr. Budi Santoso',
                'email' => 'dr.budi@pulsecare.com',
                'phone' => '081234567892',
                'gender' => 'male',
                'password' => Hash::make('password'),
                'role_id' => $doctorRole->id,
                'email_verified_at' => now(),
            ]
        ];

        foreach ($doctors as $doctor) {
            User::updateOrCreate(
                ['email' => $doctor['email']],
                $doctor
            );
        }

        $this->command->info('Doctor users created successfully!');
    }
}
