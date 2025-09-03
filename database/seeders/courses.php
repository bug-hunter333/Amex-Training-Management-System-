<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class Courses extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'title' => 'Full Stack Development',
                'description' => 'Master modern web development with React, Node.js, and database management. This comprehensive course covers everything from frontend development with React to backend APIs with Node.js, including database design and deployment strategies.',
                'slug' => 'full-stack-development',
                'category' => 'technical',
                'course_type' => 'in-person',
                'difficulty_level' => 'advanced',
                'duration_weeks' => 8,
                'duration_hours' => 120,
                'price' => 1299.00,
                'prerequisites' => json_encode([
                    'Basic HTML, CSS, JavaScript knowledge',
                    'Understanding of programming concepts',
                    'Familiarity with command line interface'
                ]),
                'learning_objectives' => json_encode([
                    'Build full-stack web applications using React and Node.js',
                    'Design and implement RESTful APIs',
                    'Work with databases (SQL and NoSQL)',
                    'Deploy applications to cloud platforms',
                    'Implement authentication and authorization',
                    'Use version control with Git and GitHub'
                ]),
                'course_outline' => 'Week 1-2: React Fundamentals & Components
            Week 3-4: State Management & React Hooks
            Week 5-6: Node.js & Express.js Backend Development
            Week 7: Database Integration & API Development
            Week 8: Testing, Deployment & Best Practices',
                'certificate_type' => 'completion',
                'max_participants' => 25,
                'min_participants' => 5,
                'auto_enrollment' => false,
                'enrollment_start_date' => now()->addDays(7),
                'enrollment_end_date' => now()->addDays(21),
                'start_date' => now()->addDays(30),
                'end_date' => now()->addDays(86),
                'schedule' => json_encode([
                    'days' => ['Monday', 'Wednesday', 'Friday'],
                    'time' => '18:00-20:00',
                    'timezone' => 'EST'
                ]),
                'timezone' => 'America/New_York',
                'venue_type' => 'physical',
                'venue_name' => 'AMEX Technology Training Center',
                'venue_address' => '200 Vesey Street, Tech Lab A, New York, NY 10281',
                'lecturer_name' => 'Dr. Sarah Chen',
                'lecturer_email' => 'sarah.chen@amex.com',
                'lecturer_bio' => 'Senior Software Architect with 12+ years experience in full-stack development. Former lead developer at Google and Microsoft.',
                'trainer_id' => 1, // Assuming trainer with ID 1 exists
                'materials' => json_encode([
                    'Course Handbook PDF',
                    'Code Examples Repository',
                    'Video Tutorials Library',
                    'Practice Exercises'
                ]),
                'resources' => json_encode([
                    'MDN Web Docs',
                    'React Official Documentation',
                    'Node.js Documentation',
                    'Stack Overflow Community'
                ]),
                'status' => 'published',
                'is_active' => true,
                'is_featured' => true,
                'is_mandatory' => false,
                'meta_title' => 'Full Stack Development Course - Master React & Node.js',
                'meta_description' => 'Learn full-stack web development with React, Node.js, and modern tools. 8-week intensive course with hands-on projects.',
                'thumbnail' => 'courses/thumbnails/fullstack-dev.jpg',
                'tags' => json_encode(['React', 'Node.js', 'JavaScript', 'Web Development', 'Full Stack']),
                'target_departments' => json_encode(['IT', 'Engineering', 'Product']),
                'target_roles' => json_encode(['Developer', 'Software Engineer', 'Full Stack Developer']),
                'target_levels' => json_encode(['mid', 'senior']),
                'requires_approval' => false,
                'average_rating' => 4.7,
                'total_reviews' => 45,
                'view_count' => 234,
                'enrollment_count' => 18,
                'completion_count' => 12
            ],
            [
                'title' => 'Cybersecurity Fundamentals',
                'description' => 'Essential security practices, threat detection, and risk management strategies. Learn to protect organizational assets from cyber threats and implement comprehensive security frameworks.',
                'slug' => 'cybersecurity-fundamentals',
                'category' => 'technical',
                'course_type' => 'in-person',
                'difficulty_level' => 'intermediate',
                'duration_weeks' => 6,
                'duration_hours' => 72,
                'price' => 899.00,
                'prerequisites' => json_encode([
                    'Basic networking knowledge',
                    'Understanding of operating systems',
                    'Familiarity with computer systems'
                ]),
                'learning_objectives' => json_encode([
                    'Identify common cybersecurity threats and vulnerabilities',
                    'Implement security best practices and policies',
                    'Understand risk assessment and management',
                    'Deploy security monitoring tools',
                    'Respond to security incidents effectively',
                    'Ensure compliance with security standards'
                ]),
                'course_outline' => 'Week 1: Introduction to Cybersecurity & Threat Landscape
Week 2: Network Security & Firewalls
Week 3: Identity and Access Management
Week 4: Incident Response & Forensics
Week 5: Risk Assessment & Compliance
Week 6: Security Monitoring & Tools',
                'certificate_type' => 'achievement',
                'max_participants' => 20,
                'min_participants' => 8,
                'auto_enrollment' => false,
                'enrollment_start_date' => now()->addDays(14),
                'enrollment_end_date' => now()->addDays(28),
                'start_date' => now()->addDays(35),
                'end_date' => now()->addDays(77),
                'schedule' => json_encode([
                    'days' => ['Tuesday', 'Thursday'],
                    'time' => '14:00-17:00',
                    'timezone' => 'EST'
                ]),
                'timezone' => 'America/New_York',
                'venue_type' => 'physical',
                'venue_name' => 'AMEX Cybersecurity Training Lab',
                'venue_address' => '200 Vesey Street, Security Wing Floor 15, New York, NY 10281',
                'lecturer_name' => 'Michael Rodriguez',
                'lecturer_email' => 'michael.rodriguez@amex.com',
                'lecturer_bio' => 'Certified Information Security Manager (CISM) with 15+ years in cybersecurity. Former FBI cybercrime investigator.',
                'trainer_id' => 2,
                'materials' => json_encode([
                    'Cybersecurity Handbook',
                    'Lab Environment Access',
                    'Security Tools Suite',
                    'Case Study Materials'
                ]),
                'resources' => json_encode([
                    'NIST Cybersecurity Framework',
                    'OWASP Top 10',
                    'Security Industry Resources',
                    'Threat Intelligence Feeds'
                ]),
                'status' => 'published',
                'is_active' => true,
                'is_featured' => true,
                'is_mandatory' => true,
                'meta_title' => 'Cybersecurity Fundamentals - Essential Security Training',
                'meta_description' => 'Learn cybersecurity fundamentals, threat detection, and risk management. 6-week comprehensive security training program.',
                'thumbnail' => 'courses/thumbnails/cybersecurity.jpg',
                'tags' => json_encode(['Cybersecurity', 'Security', 'Risk Management', 'Compliance']),
                'target_departments' => json_encode(['IT', 'Security', 'Operations']),
                'target_roles' => json_encode(['Security Analyst', 'IT Administrator', 'Risk Manager']),
                'target_levels' => json_encode(['junior', 'mid']),
                'requires_approval' => true,
                'average_rating' => 4.5,
                'total_reviews' => 32,
                'view_count' => 189,
                'enrollment_count' => 24,
                'completion_count' => 19
            ],
            [
                'title' => 'Executive Leadership',
                'description' => 'Strategic thinking, team management, and decision-making for senior leaders. Develop advanced leadership skills to drive organizational success and inspire high-performing teams.',
                'slug' => 'executive-leadership',
                'category' => 'leadership',
                'course_type' => 'in-person',
                'difficulty_level' => 'expert',
                'duration_weeks' => 4,
                'duration_hours' => 32,
                'price' => 2499.00,
                'prerequisites' => json_encode([
                    'Minimum 5 years management experience',
                    'Current leadership role or promotion pending',
                    'Executive sponsorship required'
                ]),
                'learning_objectives' => json_encode([
                    'Develop strategic thinking and planning capabilities',
                    'Master advanced team leadership techniques',
                    'Enhance decision-making under uncertainty',
                    'Build organizational change management skills',
                    'Improve stakeholder communication and influence',
                    'Create high-performance team cultures'
                ]),
                'course_outline' => 'Week 1: Strategic Leadership & Vision Setting
Week 2: Advanced Team Dynamics & Performance Management
Week 3: Decision Making & Risk Assessment
Week 4: Organizational Change & Influence Strategies',
                'certificate_type' => 'achievement',
                'max_participants' => 15,
                'min_participants' => 8,
                'auto_enrollment' => false,
                'enrollment_start_date' => now()->addDays(21),
                'enrollment_end_date' => now()->addDays(35),
                'start_date' => now()->addDays(42),
                'end_date' => now()->addDays(70),
                'schedule' => json_encode([
                    'days' => ['Monday', 'Tuesday'],
                    'time' => '09:00-17:00',
                    'timezone' => 'EST'
                ]),
                'timezone' => 'America/New_York',
                'venue_type' => 'physical',
                'venue_name' => 'AMEX Executive Training Facility',
                'venue_address' => '200 Vesey Street, Executive Conference Center Floor 25, New York, NY 10281',
                'lecturer_name' => 'Dr. Amanda Foster',
                'lecturer_email' => 'amanda.foster@amex.com',
                'lecturer_bio' => 'Former McKinsey Partner and Harvard Business School professor. 20+ years experience in executive coaching and organizational development.',
                'trainer_id' => 3,
                'materials' => json_encode([
                    'Executive Leadership Playbook',
                    'Case Study Portfolio',
                    'Leadership Assessment Tools',
                    'Strategic Planning Templates'
                ]),
                'resources' => json_encode([
                    'Harvard Business Review Leadership Collection',
                    'McKinsey Leadership Insights',
                    'Executive Coaching Resources',
                    'Leadership Network Access'
                ]),
                'status' => 'published',
                'is_active' => true,
                'is_featured' => true,
                'is_mandatory' => false,
                'meta_title' => 'Executive Leadership Program - Senior Leadership Development',
                'meta_description' => 'Advanced leadership training for executives. Strategic thinking, team management, and decision-making skills development.',
                'thumbnail' => 'courses/thumbnails/executive-leadership.jpg',
                'tags' => json_encode(['Leadership', 'Executive', 'Strategy', 'Management']),
                'target_departments' => json_encode(['Executive', 'Management', 'All Departments']),
                'target_roles' => json_encode(['CEO', 'VP', 'Director', 'Senior Manager']),
                'target_levels' => json_encode(['executive']),
                'requires_approval' => true,
                'average_rating' => 4.9,
                'total_reviews' => 28,
                'view_count' => 156,
                'enrollment_count' => 12,
                'completion_count' => 11
            ],
            [
                'title' => 'Project Management Mastery',
                'description' => 'Agile methodologies, resource planning, and team coordination techniques. Master project management frameworks including Scrum, Kanban, and traditional waterfall approaches.',
                'slug' => 'project-management-mastery',
                'category' => 'leadership',
                'course_type' => 'in-person',
                'difficulty_level' => 'intermediate',
                'duration_weeks' => 5,
                'duration_hours' => 60,
                'price' => 799.00,
                'prerequisites' => json_encode([
                    'Basic understanding of project concepts',
                    'Some team collaboration experience',
                    'Familiarity with project tools (preferred)'
                ]),
                'learning_objectives' => json_encode([
                    'Master Agile and Scrum methodologies',
                    'Develop effective resource planning skills',
                    'Learn advanced team coordination techniques',
                    'Implement project risk management strategies',
                    'Use project management tools effectively',
                    'Achieve PMP/Scrum Master certification readiness'
                ]),
                'course_outline' => 'Week 1: Project Management Fundamentals & Frameworks
Week 2: Agile & Scrum Methodologies
Week 3: Resource Planning & Budget Management
Week 4: Risk Management & Quality Assurance
Week 5: Team Leadership & Stakeholder Communication',
                'certificate_type' => 'completion',
                'max_participants' => 30,
                'min_participants' => 10,
                'auto_enrollment' => false,
                'enrollment_start_date' => now()->addDays(10),
                'enrollment_end_date' => now()->addDays(24),
                'start_date' => now()->addDays(28),
                'end_date' => now()->addDays(63),
                'schedule' => json_encode([
                    'days' => ['Wednesday', 'Friday'],
                    'time' => '10:00-13:00',
                    'timezone' => 'EST'
                ]),
                'timezone' => 'America/New_York',
                'venue_type' => 'physical',
                'venue_name' => 'AMEX Project Management Institute',
                'venue_address' => '200 Vesey Street, Training Room C Floor 12, New York, NY 10281',
                'lecturer_name' => 'James Thompson',
                'lecturer_email' => 'james.thompson@amex.com',
                'lecturer_bio' => 'PMP Certified Project Manager with 18+ years experience. Former Director of PMO at Fortune 500 companies.',
                'trainer_id' => 4,
                'materials' => json_encode([
                    'Project Management Toolkit',
                    'Agile Templates Library',
                    'Case Study Examples',
                    'Certification Prep Materials'
                ]),
                'resources' => json_encode([
                    'PMI Standards and Guidelines',
                    'Scrum.org Resources',
                    'Project Management Software Trials',
                    'Professional Community Access'
                ]),
                'status' => 'published',
                'is_active' => true,
                'is_featured' => false,
                'is_mandatory' => false,
                'meta_title' => 'Project Management Mastery - Agile & Traditional Methods',
                'meta_description' => 'Comprehensive project management training covering Agile, Scrum, and traditional methodologies. 5-week intensive program.',
                'thumbnail' => 'courses/thumbnails/project-management.jpg',
                'tags' => json_encode(['Project Management', 'Agile', 'Scrum', 'Planning', 'Leadership']),
                'target_departments' => json_encode(['Project Management', 'IT', 'Operations', 'Marketing']),
                'target_roles' => json_encode(['Project Manager', 'Scrum Master', 'Team Lead', 'Product Manager']),
                'target_levels' => json_encode(['mid', 'senior']),
                'requires_approval' => false,
                'average_rating' => 4.6,
                'total_reviews' => 67,
                'view_count' => 278,
                'enrollment_count' => 34,
                'completion_count' => 29
            ],
            [
                'title' => 'Data Privacy & GDPR Compliance',
                'description' => 'Understanding data protection regulations and compliance requirements. Comprehensive training on GDPR, CCPA, and other privacy laws affecting modern businesses.',
                'slug' => 'data-privacy-gdpr-compliance',
                'category' => 'compliance',
                'course_type' => 'in-person',
                'difficulty_level' => 'essential',
                'duration_weeks' => 3,
                'duration_hours' => 24,
                'price' => 399.00,
                'prerequisites' => json_encode([
                    'Basic understanding of data handling',
                    'Familiarity with business processes',
                    'No prior legal knowledge required'
                ]),
                'learning_objectives' => json_encode([
                    'Understand GDPR and privacy law requirements',
                    'Implement data protection measures',
                    'Conduct privacy impact assessments',
                    'Handle data subject requests effectively',
                    'Ensure compliance across business operations',
                    'Manage data breach response procedures'
                ]),
                'course_outline' => 'Week 1: Introduction to Data Privacy Laws & GDPR Fundamentals
Week 2: Implementation Strategies & Data Protection Measures
Week 3: Compliance Monitoring & Breach Response',
                'certificate_type' => 'completion',
                'max_participants' => 50,
                'min_participants' => 15,
                'auto_enrollment' => true,
                'enrollment_start_date' => now()->addDays(5),
                'enrollment_end_date' => now()->addDays(19),
                'start_date' => now()->addDays(21),
                'end_date' => now()->addDays(42),
                'schedule' => json_encode([
                    'days' => ['Monday', 'Wednesday', 'Friday'],
                    'time' => '11:00-13:00',
                    'timezone' => 'EST'
                ]),
                'timezone' => 'America/New_York',
                'venue_type' => 'physical',
                'venue_name' => 'AMEX Legal Compliance Center',
                'venue_address' => '200 Vesey Street, Legal Department Floor 18, New York, NY 10281',
                'lecturer_name' => 'Laura Williams',
                'lecturer_email' => 'laura.williams@amex.com',
                'lecturer_bio' => 'Data Privacy Attorney and CIPP/E certified professional. 10+ years experience in privacy law and GDPR implementation.',
                'trainer_id' => 5,
                'materials' => json_encode([
                    'GDPR Compliance Handbook',
                    'Privacy Policy Templates',
                    'Compliance Checklists',
                    'Legal Updates Newsletter'
                ]),
                'resources' => json_encode([
                    'EU GDPR Official Text',
                    'Privacy Authority Guidelines',
                    'Industry Best Practices',
                    'Compliance Software Tools'
                ]),
                'status' => 'published',
                'is_active' => true,
                'is_featured' => false,
                'is_mandatory' => true,
                'meta_title' => 'Data Privacy & GDPR Compliance Training - Essential Knowledge',
                'meta_description' => 'Essential GDPR and data privacy compliance training. Learn regulations, implementation, and best practices in 3 weeks.',
                'thumbnail' => 'courses/thumbnails/data-privacy.jpg',
                'tags' => json_encode(['GDPR', 'Data Privacy', 'Compliance', 'Legal', 'Data Protection']),
                'target_departments' => json_encode(['Legal', 'IT', 'HR', 'Marketing', 'All Departments']),
                'target_roles' => json_encode(['Data Protection Officer', 'Compliance Manager', 'IT Manager', 'All Employees']),
                'target_levels' => json_encode(['junior', 'mid', 'senior']),
                'requires_approval' => false,
                'average_rating' => 4.3,
                'total_reviews' => 89,
                'view_count' => 445,
                'enrollment_count' => 78,
                'completion_count' => 71
            ],
            [
                'title' => 'Effective Communication Skills',
                'description' => 'Effective communication, presentation skills, and active listening techniques. Develop professional communication abilities for enhanced workplace collaboration and leadership.',
                'slug' => 'effective-communication-skills',
                'category' => 'soft-skills',
                'course_type' => 'in-person',
                'difficulty_level' => 'beginner',
                'duration_weeks' => 4,
                'duration_hours' => 32,
                'price' => 499.00,
                'prerequisites' => json_encode([
                    'No prior experience required',
                    'Willingness to participate in group activities',
                    'Basic English proficiency'
                ]),
                'learning_objectives' => json_encode([
                    'Master verbal and non-verbal communication',
                    'Develop confident presentation skills',
                    'Practice active listening techniques',
                    'Improve written communication clarity',
                    'Handle difficult conversations effectively',
                    'Build professional networking abilities'
                ]),
                'course_outline' => 'Week 1: Communication Fundamentals & Active Listening
Week 2: Presentation Skills & Public Speaking
Week 3: Written Communication & Digital Etiquette
Week 4: Difficult Conversations & Conflict Resolution',
                'certificate_type' => 'completion',
                'max_participants' => 25,
                'min_participants' => 12,
                'auto_enrollment' => false,
                'enrollment_start_date' => now()->addDays(3),
                'enrollment_end_date' => now()->addDays(17),
                'start_date' => now()->addDays(21),
                'end_date' => now()->addDays(49),
                'schedule' => json_encode([
                    'days' => ['Tuesday', 'Thursday'],
                    'time' => '16:00-18:00',
                    'timezone' => 'EST'
                ]),
                'timezone' => 'America/New_York',
                'venue_type' => 'physical',
                'venue_name' => 'AMEX Communication Skills Lab',
                'venue_address' => '200 Vesey Street, Professional Development Center Floor 8, New York, NY 10281',
                'lecturer_name' => 'Dr. Patricia Garcia',
                'lecturer_email' => 'patricia.garcia@amex.com',
                'lecturer_bio' => 'Communication specialist and certified executive coach. Former corporate trainer with 14+ years experience in professional development.',
                'trainer_id' => 6,
                'materials' => json_encode([
                    'Communication Skills Workbook',
                    'Presentation Templates',
                    'Practice Exercise Library',
                    'Self-Assessment Tools'
                ]),
                'resources' => json_encode([
                    'TED Talks on Communication',
                    'Professional Speaking Resources',
                    'Writing Style Guides',
                    'Communication Apps and Tools'
                ]),
                'status' => 'published',
                'is_active' => true,
                'is_featured' => false,
                'is_mandatory' => false,
                'meta_title' => 'Effective Communication Skills - Professional Development',
                'meta_description' => 'Improve communication, presentation, and listening skills. 4-week practical training for workplace success.',
                'thumbnail' => 'courses/thumbnails/communication-skills.jpg',
                'tags' => json_encode(['Communication', 'Presentation', 'Soft Skills', 'Professional Development']),
                'target_departments' => json_encode(['All Departments']),
                'target_roles' => json_encode(['All Roles', 'New Employees', 'Team Members']),
                'target_levels' => json_encode(['junior', 'mid']),
                'requires_approval' => false,
                'average_rating' => 4.4,
                'total_reviews' => 123,
                'view_count' => 567,
                'enrollment_count' => 89,
                'completion_count' => 76
            ]
        ];
        foreach ($courses as $course) {
            DB::table('courses')->insert(array_merge($course, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
    }
}
