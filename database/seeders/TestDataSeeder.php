<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trainer;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Session;
use App\Models\CourseFeedback;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key constraints temporarily to avoid constraint violations
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            $this->seedData();
        } finally {
            // Re-enable foreign key constraints
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }

    private function seedData(): void
    {
        // Check what columns exist in the tables
        $trainerColumns = Schema::getColumnListing('trainers');
        $courseColumns = Schema::getColumnListing('courses');
        
        // Log trainer columns for debugging
        $this->command->info('Trainer table columns: ' . implode(', ', $trainerColumns));
        
        // Define trainer data
        $trainerData = [
            [
                'trainer_name' => 'Dr. Sarah Chen',
                'trainer_mail' => 'sarah.chen@amex.com',
                'employee_id' => 'TR0001',
                'department' => 'Technology Department',
                'specialization' => 'Full-Stack Development',
                'bio' => 'Senior Software Architect with 12+ years experience in full-stack development. Former lead developer at Google and Microsoft.',
                'phone' => '+1-555-0001',
                'experience_years' => 12,
                'hourly_rate' => 125.00,
                'max_courses_per_month' => 6,
                'certifications' => 'AWS Solutions Architect, Google Cloud Professional, Microsoft Azure Expert',
                'linkedin_profile' => 'https://linkedin.com/in/sarahchen',
                'role' => 'trainer',
                'is_trainer' => true,
            ],
            [
                'trainer_name' => 'Michael Rodriguez',
                'trainer_mail' => 'michael.rodriguez@amex.com',
                'employee_id' => 'TR0002',
                'department' => 'Security Department',
                'specialization' => 'Cybersecurity & Information Security',
                'bio' => 'Certified Information Security Manager (CISM) with 15+ years in cybersecurity. Former FBI cybercrime investigator.',
                'phone' => '+1-555-0002',
                'experience_years' => 15,
                'hourly_rate' => 135.00,
                'max_courses_per_month' => 5,
                'certifications' => 'CISM, CISSP, CEH, GCIH, Security+',
                'linkedin_profile' => 'https://linkedin.com/in/michaelrodriguez',
                'role' => 'trainer',
                'is_trainer' => true,
            ],
            [
                'trainer_name' => 'Dr. Amanda Foster',
                'trainer_mail' => 'amanda.foster@amex.com',
                'employee_id' => 'TR0003',
                'department' => 'Human Resources',
                'specialization' => 'Leadership & Organizational Development',
                'bio' => 'Former McKinsey Partner and Harvard Business School professor. 20+ years experience in executive coaching and organizational development.',
                'phone' => '+1-555-0003',
                'experience_years' => 20,
                'hourly_rate' => 150.00,
                'max_courses_per_month' => 4,
                'certifications' => 'ICF Master Certified Coach, Harvard MBA, McKinsey Leadership Institute',
                'linkedin_profile' => 'https://linkedin.com/in/amandafoster',
                'role' => 'senior_trainer',
                'is_trainer' => true,
            ],
            [
                'trainer_name' => 'James Thompson',
                'trainer_mail' => 'james.thompson@amex.com',
                'employee_id' => 'TR0004',
                'department' => 'Operations Department',
                'specialization' => 'Project Management & Operations',
                'bio' => 'PMP Certified Project Manager with 18+ years experience. Former Director of PMO at Fortune 500 companies.',
                'phone' => '+1-555-0004',
                'experience_years' => 18,
                'hourly_rate' => 110.00,
                'max_courses_per_month' => 7,
                'certifications' => 'PMP, PMI-ACP, Prince2, Lean Six Sigma Black Belt',
                'linkedin_profile' => 'https://linkedin.com/in/jamesthompson',
                'role' => 'trainer',
                'is_trainer' => true,
            ],
            [
                'trainer_name' => 'Laura Williams',
                'trainer_mail' => 'laura.williams@amex.com',
                'employee_id' => 'TR0005',
                'department' => 'Legal & Compliance',
                'specialization' => 'Data Privacy & Compliance',
                'bio' => 'Data Privacy Attorney and CIPP/E certified professional. 10+ years experience in privacy law and GDPR implementation.',
                'phone' => '+1-555-0005',
                'experience_years' => 10,
                'hourly_rate' => 140.00,
                'max_courses_per_month' => 5,
                'certifications' => 'CIPP/E, CIPM, CIPT, J.D., Bar Certified',
                'linkedin_profile' => 'https://linkedin.com/in/laurawilliams',
                'role' => 'trainer',
                'is_trainer' => true,
            ],
            [
                'trainer_name' => 'Dr. Patricia Garcia',
                'trainer_mail' => 'patricia.garcia@amex.com',
                'employee_id' => 'TR0006',
                'department' => 'Training & Development',
                'specialization' => 'Communication & Professional Development',
                'bio' => 'Communication specialist and certified executive coach. Former corporate trainer with 14+ years experience in professional development.',
                'phone' => '+1-555-0006',
                'experience_years' => 14,
                'hourly_rate' => 95.00,
                'max_courses_per_month' => 8,
                'certifications' => 'ICF Associate Certified Coach, Dale Carnegie Certified, PhD in Communications',
                'linkedin_profile' => 'https://linkedin.com/in/patriciagarcia',
                'role' => 'trainer',
                'is_trainer' => true,
            ],
        ];

        $createdTrainers = [];

        // Create trainers directly
        foreach ($trainerData as $index => $data) {
            try {
                // Check if trainer already exists by email
                $trainer = Trainer::where('trainer_mail', $data['trainer_mail'])->first();
                
                if (!$trainer) {
                    // Build trainer record with only existing columns
                    $trainerRecord = [];
                    
                    // Add all fields that exist in the trainers table
                    foreach ($data as $key => $value) {
                        if (in_array($key, $trainerColumns)) {
                            $trainerRecord[$key] = $value;
                        }
                    }
                    
                    // Add default values for common fields
                    if (in_array('is_active', $trainerColumns)) {
                        $trainerRecord['is_active'] = true;
                    }
                    
                    if (in_array('trainer_password', $trainerColumns)) {
                        $trainerRecord['trainer_password'] = Hash::make('password');
                    }

                    $trainer = Trainer::create($trainerRecord);
                    $this->command->info('Created trainer: ' . $data['trainer_name']);
                } else {
                    $this->command->info('Trainer already exists: ' . $data['trainer_name']);
                }

                $createdTrainers[] = $trainer;
                
            } catch (\Exception $e) {
                $this->command->error('Failed to create trainer ' . $data['trainer_name'] . ': ' . $e->getMessage());
                continue;
            }
        }

        // Clean up existing test data
        foreach ($createdTrainers as $trainer) {
            try {
                $existingCourses = Course::where('trainer_id', $trainer->id)->get();
                foreach ($existingCourses as $course) {
                    if (Schema::hasTable('sessions')) {
                        Session::where('course_id', $course->id)->delete();
                    }
                    if (Schema::hasTable('course_feedback')) {
                        CourseFeedback::where('course_id', $course->id)->delete();
                    }
                    if (Schema::hasTable('enrollments')) {
                        Enrollment::where('course_id', $course->id)->delete();
                    }
                }
                Course::where('trainer_id', $trainer->id)->delete();
            } catch (\Exception $e) {
                $this->command->warn('Warning during cleanup for trainer ' . $trainer->id . ': ' . $e->getMessage());
            }
        }
        
        $this->command->info('Cleaned up existing test data.');

        // Create test courses for each trainer
        $courseTemplates = [
            // Dr. Sarah Chen - Full-Stack Development
            [
                'title' => 'Advanced React Development',
                'description' => 'Master React ecosystem with hooks, context, and modern patterns for enterprise applications.',
                'slug' => 'advanced-react-development',
                'category' => 'Technical',
                'specialization' => 'Frontend Development',
            ],
            [
                'title' => 'Microservices Architecture with Node.js',
                'description' => 'Build scalable microservices using Node.js, Docker, and Kubernetes.',
                'slug' => 'microservices-nodejs',
                'category' => 'Technical',
                'specialization' => 'Backend Development',
            ],
            // Michael Rodriguez - Cybersecurity
            [
                'title' => 'Advanced Penetration Testing',
                'description' => 'Hands-on penetration testing techniques and methodologies for enterprise security.',
                'slug' => 'advanced-penetration-testing',
                'category' => 'Security',
                'specialization' => 'Ethical Hacking',
            ],
            [
                'title' => 'Incident Response & Digital Forensics',
                'description' => 'Comprehensive incident response procedures and digital forensics investigation techniques.',
                'slug' => 'incident-response-forensics',
                'category' => 'Security',
                'specialization' => 'Incident Response',
            ],
            // Dr. Amanda Foster - Leadership
            [
                'title' => 'Executive Leadership Mastery',
                'description' => 'Advanced leadership strategies for C-level executives and senior managers.',
                'slug' => 'executive-leadership-mastery',
                'category' => 'Leadership',
                'specialization' => 'Executive Coaching',
            ],
            [
                'title' => 'Organizational Change Management',
                'description' => 'Lead successful organizational transformations and change initiatives.',
                'slug' => 'organizational-change-management',
                'category' => 'Management',
                'specialization' => 'Change Management',
            ],
            // James Thompson - Project Management
            [
                'title' => 'Agile Project Management Certification',
                'description' => 'Comprehensive Agile methodologies including Scrum, Kanban, and SAFe frameworks.',
                'slug' => 'agile-project-management',
                'category' => 'Management',
                'specialization' => 'Agile Methodology',
            ],
            [
                'title' => 'Advanced Risk Management',
                'description' => 'Enterprise risk assessment, mitigation strategies, and risk governance frameworks.',
                'slug' => 'advanced-risk-management',
                'category' => 'Management',
                'specialization' => 'Risk Management',
            ],
            // Laura Williams - Legal & Compliance
            [
                'title' => 'GDPR Compliance Masterclass',
                'description' => 'Complete guide to GDPR compliance, data protection, and privacy by design.',
                'slug' => 'gdpr-compliance-masterclass',
                'category' => 'Compliance',
                'specialization' => 'Data Privacy',
            ],
            [
                'title' => 'Financial Services Regulatory Compliance',
                'description' => 'Navigate complex financial regulations including SOX, PCI-DSS, and banking compliance.',
                'slug' => 'financial-regulatory-compliance',
                'category' => 'Compliance',
                'specialization' => 'Financial Compliance',
            ],
            // Dr. Patricia Garcia - Communication
            [
                'title' => 'Executive Communication Excellence',
                'description' => 'Advanced communication skills for senior leaders including public speaking and stakeholder management.',
                'slug' => 'executive-communication-excellence',
                'category' => 'Professional Development',
                'specialization' => 'Executive Communication',
            ],
            [
                'title' => 'Cross-Cultural Communication',
                'description' => 'Navigate global business environments with effective cross-cultural communication strategies.',
                'slug' => 'cross-cultural-communication',
                'category' => 'Professional Development',
                'specialization' => 'Intercultural Skills',
            ],
        ];

        $courseIndex = 0;
        foreach ($createdTrainers as $trainer) {
            // Assign 2 courses per trainer
            for ($i = 0; $i < 2 && $courseIndex < count($courseTemplates); $i++, $courseIndex++) {
                try {
                    $template = $courseTemplates[$courseIndex];
                    
                    // Build course data with only existing columns
                    $courseData = [
                        'trainer_id' => $trainer->id,
                        'title' => $template['title'],
                        'description' => $template['description'],
                    ];

                    // Add optional fields only if columns exist
                    $optionalFields = [
                        'slug' => $template['slug'],
                        'category' => $template['category'],
                        'course_type' => 'instructor_led',
                        'difficulty_level' => ['intermediate', 'advanced'][rand(0, 1)],
                        'duration_weeks' => rand(4, 8),
                        'duration_hours' => rand(30, 60),
                        'price' => 0.00,
                        'prerequisites' => 'Professional experience in relevant field',
                        'learning_objectives' => 'Master advanced concepts, Apply practical skills, Achieve certification',
                        'course_outline' => 'Week 1: Fundamentals, Week 2-3: Core concepts, Week 4+: Advanced topics',
                        'certificate_type' => 'professional',
                        'max_participants' => rand(12, 20),
                        'min_participants' => rand(6, 10),
                        'auto_enrollment' => false,
                        'enrollment_start_date' => Carbon::now(),
                        'enrollment_end_date' => Carbon::now()->addDays(30),
                        'start_date' => Carbon::now()->addDays(rand(5, 15)),
                        'end_date' => Carbon::now()->addDays(rand(40, 70)),
                        'schedule' => ['Monday & Wednesday 2:00 PM - 4:00 PM', 'Tuesday & Thursday 10:00 AM - 12:00 PM'][rand(0, 1)],
                        'timezone' => 'UTC',
                        'venue_type' => ['physical', 'online', 'hybrid'][rand(0, 2)],
                        'venue_name' => 'Training Center ' . chr(65 + $i),
                        'venue_address' => (100 + $courseIndex) . ' Training Blvd, Floor ' . ($i + 1),
                        'online_platform' => 'Microsoft Teams',
                        'lecturer_name' => $trainer->trainer_name ?? 'Unknown',
                        'lecturer_email' => $trainer->trainer_mail ?? 'unknown@amex.com',
                        'lecturer_bio' => $trainer->bio ?? 'Professional trainer',
                        'materials' => 'Course materials, Lab exercises, Reference guides',
                        'resources' => 'Online resources, Practice environments, Video tutorials',
                        'status' => 'active',
                        'is_active' => true,
                        'is_featured' => rand(0, 1) == 1,
                        'is_mandatory' => rand(0, 3) == 1,
                        'meta_title' => $template['title'] . ' - American Express Training',
                        'meta_description' => 'Professional training: ' . $template['description'],
                        'thumbnail' => strtolower(str_replace(' ', '-', $template['title'])) . '-thumb.jpg',
                        'tags' => strtolower(str_replace(' ', ',', $template['specialization'])) . ',training,professional',
                        'target_departments' => $trainer->department ?? 'General',
                        'target_roles' => 'Senior,' . ucfirst(strtolower($template['specialization'])),
                        'target_levels' => 'senior,expert',
                        'requires_approval' => rand(0, 1) == 1,
                        'average_rating' => round(3.5 + (rand(0, 15) / 10), 1),
                        'total_reviews' => rand(5, 30),
                        'view_count' => rand(50, 200),
                        'enrollment_count' => rand(8, 18),
                        'completion_count' => rand(5, 15),
                    ];

                    // Filter out fields that don't exist in the table
                    $filteredCourseData = [];
                    foreach ($courseData as $key => $value) {
                        if (in_array($key, $courseColumns)) {
                            $filteredCourseData[$key] = $value;
                        }
                    }

                    foreach ($optionalFields as $key => $value) {
                        if (in_array($key, $courseColumns)) {
                            $filteredCourseData[$key] = $value;
                        }
                    }

                    Course::updateOrCreate(
                        ['slug' => $filteredCourseData['slug'] ?? $template['slug']], 
                        $filteredCourseData
                    );
                    
                } catch (\Exception $e) {
                    $this->command->error('Failed to create course for trainer ' . $trainer->id . ': ' . $e->getMessage());
                    continue;
                }
            }
        }

        $createdCourses = Course::whereIn('trainer_id', collect($createdTrainers)->pluck('id'))->get();
        $this->command->info('Created ' . $createdCourses->count() . ' courses for all trainers.');

        // Create sessions for active courses
        if (Schema::hasTable('sessions')) {
            $sessionColumns = Schema::getColumnListing('sessions');
            
            foreach ($createdCourses->where('status', 'active') as $course) {
                try {
                    // Create 2-3 sessions per course
                    for ($i = 0; $i < rand(2, 3); $i++) {
                        $sessionData = [
                            'course_id' => $course->id,
                            'title' => $course->title . ' - Session ' . ($i + 1),
                            'description' => 'Session ' . ($i + 1) . ' covering key concepts and practical applications',
                        ];
                        
                        // Add optional session fields
                        $optionalSessionFields = [
                            'session_date' => Carbon::now()->addDays(rand(1, 30)),
                            'start_time' => ['09:00:00', '10:00:00', '14:00:00'][rand(0, 2)],
                            'end_time' => ['12:00:00', '13:00:00', '17:00:00'][rand(0, 2)],
                            'location' => 'Training Room ' . chr(65 + $i),
                            'max_participants' => $course->max_participants ?? 20,
                            'status' => 'scheduled',
                        ];

                        foreach ($optionalSessionFields as $key => $value) {
                            if (in_array($key, $sessionColumns)) {
                                $sessionData[$key] = $value;
                            }
                        }
                        
                        Session::create($sessionData);
                    }
                } catch (\Exception $e) {
                    $this->command->warn('Failed to create sessions for course ' . $course->id . ': ' . $e->getMessage());
                }
            }
            $this->command->info('Created training sessions for all courses.');
        }

        // Create basic enrollments (simplified since we removed User dependency)
        if (Schema::hasTable('enrollments')) {
            $enrollmentColumns = Schema::getColumnListing('enrollments');
            
            // Create some sample enrollments
            for ($i = 1; $i <= 20; $i++) {
                try {
                    $email = 'employee' . $i . '@amex.com';
                    
                    // Enroll in random courses
                    foreach ($createdCourses->where('status', 'active')->random(min(3, $createdCourses->where('status', 'active')->count())) as $course) {
                        $existingEnrollment = Enrollment::where('trainee_email', $email)
                            ->where('course_id', $course->id)
                            ->first();
                            
                        if (!$existingEnrollment) {
                            $enrollmentData = [
                                'course_id' => $course->id,
                                'trainee_name' => 'Employee ' . $i,
                                'trainee_email' => $email,
                            ];

                            // Add optional enrollment fields
                            $optionalEnrollmentFields = [
                                'trainee_phone' => '+1-555-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                                'date_of_birth' => Carbon::now()->subYears(rand(25, 45))->format('Y-m-d'),
                                'gender' => rand(0, 1) ? 'Male' : 'Female',
                                'education_level' => ['Bachelor', 'Master', 'PhD', 'High School', 'Diploma'][rand(0, 4)],
                                'trainee_address' => rand(100, 999) . ' Training St, City, State',
                                'previous_experience' => rand(0, 10) . ' years of relevant experience',
                                'status' => 'approved',
                                'enrollment_date' => Carbon::now()->subDays(rand(1, 20)),
                            ];

                            foreach ($optionalEnrollmentFields as $key => $value) {
                                if (in_array($key, $enrollmentColumns)) {
                                    $enrollmentData[$key] = $value;
                                }
                            }
                            
                            Enrollment::create($enrollmentData);
                        }
                    }
                } catch (\Exception $e) {
                    $this->command->error('Failed to create enrollment for employee ' . $i . ': ' . $e->getMessage());
                    continue;
                }
            }
        }

        $this->command->info('Created sample enrollments.');

        $this->command->info('Test data created successfully!');
        $this->command->info('Trainer login credentials (password: password):');
        foreach ($trainerData as $trainer) {
            $this->command->info('Email: ' . $trainer['trainer_mail']);
        }
    }
}