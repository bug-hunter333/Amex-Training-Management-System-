<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Trainer;
use Illuminate\Support\Facades\Hash;

class TrainerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trainersData = [
            [
                'name' => 'Dr. Sarah Chen',
                'email' => 'sarah.chen@amex.com',
                'employee_id' => 'TR0001',
                'department' => 'Technology Department',
                'specialization' => 'Full-Stack Development',
                'bio' => 'Senior Software Architect with 12+ years experience in full-stack development.',
                'experience_years' => 12,
                'hourly_rate' => 85.00,
                'max_courses' => 6,
            ],
            [
                'name' => 'Michael Rodriguez',
                'email' => 'michael.rodriguez@amex.com',
                'employee_id' => 'TR0002',
                'department' => 'Security Department',
                'specialization' => 'Cybersecurity & Information Security',
                'bio' => 'Certified Information Security Manager (CISM) with 15+ years in cybersecurity.',
                'experience_years' => 15,
                'hourly_rate' => 95.00,
                'max_courses' => 4,
            ],
            [
                'name' => 'Dr. Amanda Foster',
                'email' => 'amanda.foster@amex.com',
                'employee_id' => 'TR0003',
                'department' => 'Human Resources',
                'specialization' => 'Leadership & Organizational Development',
                'bio' => 'Former McKinsey Partner and Harvard Business School professor.',
                'experience_years' => 20,
                'hourly_rate' => 120.00,
                'max_courses' => 3,
            ],
            [
                'name' => 'James Thompson',
                'email' => 'james.thompson@amex.com',
                'employee_id' => 'TR0004',
                'department' => 'Operations Department',
                'specialization' => 'Project Management & Operations',
                'bio' => 'PMP Certified Project Manager with 18+ years experience.',
                'experience_years' => 18,
                'hourly_rate' => 80.00,
                'max_courses' => 5,
            ],
            [
                'name' => 'Laura Williams',
                'email' => 'laura.williams@amex.com',
                'employee_id' => 'TR0005',
                'department' => 'Legal & Compliance',
                'specialization' => 'Data Privacy & Compliance',
                'bio' => 'Data Privacy Attorney and CIPP/E certified professional.',
                'experience_years' => 10,
                'hourly_rate' => 90.00,
                'max_courses' => 4,
            ],
        ];

        foreach ($trainersData as $trainerData) {
            // Create or update the user
            $user = User::updateOrCreate(
                ['email' => $trainerData['email']],
                [
                    'name' => $trainerData['name'],
                    'email' => $trainerData['email'],
                    'password' => Hash::make('password'), // Default password
                    'user_type' => 'trainer',
                    'email_verified_at' => now(),
                ]
            );

            // Create or update the trainer profile using employee_id as the unique identifier
            Trainer::updateOrCreate(
                ['employee_id' => $trainerData['employee_id']], // Match by employee_id instead of user_id
                [
                    'user_id' => $user->id, // Update user_id in case it changed
                    'trainer_name' => $trainerData['name'],
                    'trainer_mail' => $trainerData['email'],
                    'trainer_password' => Hash::make('password'),
                    'employee_id' => $trainerData['employee_id'],
                    'department' => $trainerData['department'],
                    'bio' => $trainerData['bio'],
                    'specialization' => $trainerData['specialization'],
                    'experience_years' => $trainerData['experience_years'],
                    'hourly_rate' => $trainerData['hourly_rate'],
                    'max_courses_per_month' => $trainerData['max_courses'],
                    'certifications' => json_encode(['Professional Certification', 'Advanced Training']),
                    'phone' => '+1-555-' . substr($trainerData['employee_id'], -4),
                    'linkedin_profile' => 'https://linkedin.com/in/' . strtolower(str_replace(' ', '', $trainerData['name'])),
                    'is_active' => true,
                    'role' => 'trainer',
                    'is_trainer' => true,
                ]
            );

            $this->command->info("Created/Updated trainer user: {$trainerData['name']}");
        }

        $this->command->info('All trainer users processed successfully!');
        $this->command->info('Default password for all trainers: password');
    }
}