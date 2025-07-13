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
        $doctorRole = Role::where('name', 'doctor')->first();
        $patientRole = Role::where('name', 'patient')->first();

        if (!$doctorRole) {
            // Create doctor role if doesn't exist
            $doctorRole = Role::create([
                'name' => 'doctor',
                'description' => 'Doctor role'
            ]);
        }

        if (!$patientRole) {
            // Create patient role if doesn't exist
            $patientRole = Role::create([
                'name' => 'patient',
                'description' => 'Patient role'
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

        // Create test patient user
        User::updateOrCreate(
            ['email' => 'patient@pulsecare.com'],
            [
                'name' => 'John Doe',
                'email' => 'patient@pulsecare.com',
                'phone' => '081234567899',
                'gender' => 'male',
                'password' => Hash::make('password'),
                'role_id' => $patientRole->id,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Doctor and patient users created successfully!');
    }
}
