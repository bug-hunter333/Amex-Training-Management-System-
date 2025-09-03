<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds into the admins table.
     */
    public function run(): void
    {
        // Get existing users or create new ones if they don't exist
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'System Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        $personalUser = User::firstOrCreate(
            ['email' => 'miyulasbandara@gmail.com'],
            [
                'name' => 'Miyula Bandara',
                'email' => 'miyulasbandara@gmail.com',
                'password' => Hash::make('secure_password_123'),
                'email_verified_at' => now(),
            ]
        );

        // Seed the ADMINS TABLE with admin records
        $adminRecords = [
            [
                'user_id' => $adminUser->id,
                'permissions' => json_encode([
                    'manage_users',
                    'manage_courses',
                    'manage_trainers',
                    'manage_enrollments',
                    'manage_feedback',
                    'view_reports',
                    'manage_settings'
                ]),
                'access_level' => 'super_admin',
                'department' => 'IT Administration',
                'is_active' => true,
            ],
            [
                'user_id' => $personalUser->id,
                'permissions' => json_encode([
                    'manage_users',
                    'manage_courses',
                    'manage_trainers',
                    'manage_enrollments',
                    'manage_feedback',
                    'view_reports',
                    'manage_settings'
                ]),
                'access_level' => 'super_admin',
                'department' => 'System Owner',
                'is_active' => true,
            ]
        ];

        // Insert records into the admins table
        foreach ($adminRecords as $adminData) {
            Admin::firstOrCreate(
                ['user_id' => $adminData['user_id']],
                $adminData
            );
        }

        $this->command->info('✅ Admin records seeded successfully into the admins table!');
        $this->command->info('📊 Total admin records created: ' . count($adminRecords));
    }
}