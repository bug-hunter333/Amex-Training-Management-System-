-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2025 at 11:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `department` varchar(255) DEFAULT NULL,
  `access_level` enum('super_admin','admin','moderator') NOT NULL DEFAULT 'admin',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `user_id`, `permissions`, `department`, `access_level`, `created_by`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 76, '\"[\\\"manage_users\\\",\\\"manage_courses\\\",\\\"manage_trainers\\\",\\\"manage_enrollments\\\",\\\"manage_feedback\\\",\\\"view_reports\\\",\\\"manage_settings\\\"]\"', 'IT Administration', 'super_admin', NULL, 1, '2025-09-02 22:23:18', '2025-09-02 22:23:18');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('tms-training-management-cache-22faaf0786814bd08d0391b836ab2893', 'i:1;', 1756872643),
('tms-training-management-cache-22faaf0786814bd08d0391b836ab2893:timer', 'i:1756872643;', 1756872643);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `course_type` varchar(255) NOT NULL,
  `difficulty_level` varchar(255) NOT NULL,
  `duration_weeks` int(11) NOT NULL,
  `duration_hours` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `prerequisites` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`prerequisites`)),
  `learning_objectives` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`learning_objectives`)),
  `course_outline` text NOT NULL,
  `certificate_type` varchar(255) NOT NULL,
  `max_participants` int(11) NOT NULL,
  `min_participants` int(11) NOT NULL,
  `auto_enrollment` tinyint(1) NOT NULL DEFAULT 0,
  `enrollment_start_date` datetime NOT NULL,
  `enrollment_end_date` datetime NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `schedule` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`schedule`)),
  `timezone` varchar(255) NOT NULL,
  `venue_type` varchar(255) NOT NULL,
  `venue_name` varchar(255) DEFAULT NULL,
  `venue_address` varchar(255) DEFAULT NULL,
  `online_platform` varchar(255) DEFAULT NULL,
  `lecturer_name` varchar(255) DEFAULT NULL,
  `lecturer_email` varchar(255) DEFAULT NULL,
  `lecturer_bio` text DEFAULT NULL,
  `trainer_id` bigint(20) UNSIGNED NOT NULL,
  `materials` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`materials`)),
  `resources` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`resources`)),
  `status` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_mandatory` tinyint(1) NOT NULL DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`tags`)),
  `target_departments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`target_departments`)),
  `target_roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`target_roles`)),
  `target_levels` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`target_levels`)),
  `requires_approval` tinyint(1) NOT NULL DEFAULT 0,
  `average_rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `total_reviews` int(11) NOT NULL DEFAULT 0,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `enrollment_count` int(11) NOT NULL DEFAULT 0,
  `completion_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `slug`, `category`, `course_type`, `difficulty_level`, `duration_weeks`, `duration_hours`, `price`, `prerequisites`, `learning_objectives`, `course_outline`, `certificate_type`, `max_participants`, `min_participants`, `auto_enrollment`, `enrollment_start_date`, `enrollment_end_date`, `start_date`, `end_date`, `schedule`, `timezone`, `venue_type`, `venue_name`, `venue_address`, `online_platform`, `lecturer_name`, `lecturer_email`, `lecturer_bio`, `trainer_id`, `materials`, `resources`, `status`, `is_active`, `is_featured`, `is_mandatory`, `meta_title`, `meta_description`, `thumbnail`, `tags`, `target_departments`, `target_roles`, `target_levels`, `requires_approval`, `average_rating`, `total_reviews`, `view_count`, `enrollment_count`, `completion_count`, `created_at`, `updated_at`) VALUES
(53, 'Full Stack Development', 'Master modern web development with React, Node.js, and database management. This comprehensive course covers everything from frontend development with React to backend APIs with Node.js, including database design and deployment strategies.', 'full-stack-development', 'technical', 'in-person', 'advanced', 8, 120, 1299.00, '[\"Basic HTML, CSS, JavaScript knowledge\",\"Understanding of programming concepts\",\"Familiarity with command line interface\"]', '[\"Build full-stack web applications using React and Node.js\",\"Design and implement RESTful APIs\",\"Work with databases (SQL and NoSQL)\",\"Deploy applications to cloud platforms\",\"Implement authentication and authorization\",\"Use version control with Git and GitHub\"]', 'Week 1-2: React Fundamentals & Components\n            Week 3-4: State Management & React Hooks\n            Week 5-6: Node.js & Express.js Backend Development\n            Week 7: Database Integration & API Development\n            Week 8: Testing, Deployment & Best Practices', 'completion', 25, 5, 0, '2025-09-05 04:54:56', '2025-09-19 04:54:56', '2025-09-28 04:54:56', '2025-11-23 04:54:56', '{\"days\":[\"Monday\",\"Wednesday\",\"Friday\"],\"time\":\"18:00-20:00\",\"timezone\":\"EST\"}', 'America/New_York', 'physical', 'AMEX Technology Training Center', '200 Vesey Street, Tech Lab A, New York, NY 10281', NULL, 'Dr. Sarah Chen', 'sarah.chen@amex.com', 'Senior Software Architect with 12+ years experience in full-stack development. Former lead developer at Google and Microsoft.', 25, '[\"Course Handbook PDF\",\"Code Examples Repository\",\"Video Tutorials Library\",\"Practice Exercises\"]', '[\"MDN Web Docs\",\"React Official Documentation\",\"Node.js Documentation\",\"Stack Overflow Community\"]', 'published', 1, 1, 0, 'Full Stack Development Course - Master React & Node.js', 'Learn full-stack web development with React, Node.js, and modern tools. 8-week intensive course with hands-on projects.', 'courses/thumbnails/fullstack-dev.jpg', '[\"React\",\"Node.js\",\"JavaScript\",\"Web Development\",\"Full Stack\"]', '[\"IT\",\"Engineering\",\"Product\"]', '[\"Developer\",\"Software Engineer\",\"Full Stack Developer\"]', '[\"mid\",\"senior\"]', 0, 4.70, 45, 234, 18, 12, '2025-08-28 23:24:56', '2025-08-29 04:07:02'),
(54, 'Cybersecurity Fundamentals', 'Essential security practices, threat detection, and risk management strategies. Learn to protect organizational assets from cyber threats and implement comprehensive security frameworks.', 'cybersecurity-fundamentals', 'technical', 'in-person', 'intermediate', 6, 72, 899.00, '[\"Basic networking knowledge\",\"Understanding of operating systems\",\"Familiarity with computer systems\"]', '[\"Identify common cybersecurity threats and vulnerabilities\",\"Implement security best practices and policies\",\"Understand risk assessment and management\",\"Deploy security monitoring tools\",\"Respond to security incidents effectively\",\"Ensure compliance with security standards\"]', 'Week 1: Introduction to Cybersecurity & Threat Landscape\nWeek 2: Network Security & Firewalls\nWeek 3: Identity and Access Management\nWeek 4: Incident Response & Forensics\nWeek 5: Risk Assessment & Compliance\nWeek 6: Security Monitoring & Tools', 'achievement', 20, 8, 0, '2025-09-12 04:54:56', '2025-09-26 04:54:56', '2025-10-03 04:54:56', '2025-11-14 04:54:56', '{\"days\":[\"Tuesday\",\"Thursday\"],\"time\":\"14:00-17:00\",\"timezone\":\"EST\"}', 'America/New_York', 'physical', 'AMEX Cybersecurity Training Lab', '200 Vesey Street, Security Wing Floor 15, New York, NY 10281', NULL, 'Michael Rodriguez', 'michael.rodriguez@amex.com', 'Certified Information Security Manager (CISM) with 15+ years in cybersecurity. Former FBI cybercrime investigator.', 2, '[\"Cybersecurity Handbook\",\"Lab Environment Access\",\"Security Tools Suite\",\"Case Study Materials\"]', '[\"NIST Cybersecurity Framework\",\"OWASP Top 10\",\"Security Industry Resources\",\"Threat Intelligence Feeds\"]', 'published', 1, 1, 1, 'Cybersecurity Fundamentals - Essential Security Training', 'Learn cybersecurity fundamentals, threat detection, and risk management. 6-week comprehensive security training program.', 'courses/thumbnails/cybersecurity.jpg', '[\"Cybersecurity\",\"Security\",\"Risk Management\",\"Compliance\"]', '[\"IT\",\"Security\",\"Operations\"]', '[\"Security Analyst\",\"IT Administrator\",\"Risk Manager\"]', '[\"junior\",\"mid\"]', 1, 4.50, 32, 189, 24, 19, '2025-08-28 23:24:56', '2025-08-28 23:24:56'),
(55, 'Executive Leadership', 'Strategic thinking, team management, and decision-making for senior leaders. Develop advanced leadership skills to drive organizational success and inspire high-performing teams.', 'executive-leadership', 'leadership', 'in-person', 'expert', 4, 32, 2499.00, '[\"Minimum 5 years management experience\",\"Current leadership role or promotion pending\",\"Executive sponsorship required\"]', '[\"Develop strategic thinking and planning capabilities\",\"Master advanced team leadership techniques\",\"Enhance decision-making under uncertainty\",\"Build organizational change management skills\",\"Improve stakeholder communication and influence\",\"Create high-performance team cultures\"]', 'Week 1: Strategic Leadership & Vision Setting\nWeek 2: Advanced Team Dynamics & Performance Management\nWeek 3: Decision Making & Risk Assessment\nWeek 4: Organizational Change & Influence Strategies', 'achievement', 15, 8, 0, '2025-09-19 04:54:56', '2025-10-03 04:54:56', '2025-10-10 04:54:56', '2025-11-07 04:54:56', '{\"days\":[\"Monday\",\"Tuesday\"],\"time\":\"09:00-17:00\",\"timezone\":\"EST\"}', 'America/New_York', 'physical', 'AMEX Executive Training Facility', '200 Vesey Street, Executive Conference Center Floor 25, New York, NY 10281', NULL, 'Dr. Amanda Foster', 'amanda.foster@amex.com', 'Former McKinsey Partner and Harvard Business School professor. 20+ years experience in executive coaching and organizational development.', 3, '[\"Executive Leadership Playbook\",\"Case Study Portfolio\",\"Leadership Assessment Tools\",\"Strategic Planning Templates\"]', '[\"Harvard Business Review Leadership Collection\",\"McKinsey Leadership Insights\",\"Executive Coaching Resources\",\"Leadership Network Access\"]', 'published', 1, 1, 0, 'Executive Leadership Program - Senior Leadership Development', 'Advanced leadership training for executives. Strategic thinking, team management, and decision-making skills development.', 'courses/thumbnails/executive-leadership.jpg', '[\"Leadership\",\"Executive\",\"Strategy\",\"Management\"]', '[\"Executive\",\"Management\",\"All Departments\"]', '[\"CEO\",\"VP\",\"Director\",\"Senior Manager\"]', '[\"executive\"]', 1, 4.90, 28, 156, 12, 11, '2025-08-28 23:24:56', '2025-08-28 23:24:56'),
(56, 'Project Management Mastery', 'Agile methodologies, resource planning, and team coordination techniques. Master project management frameworks including Scrum, Kanban, and traditional waterfall approaches.', 'project-management-mastery', 'leadership', 'in-person', 'intermediate', 5, 60, 799.00, '[\"Basic understanding of project concepts\",\"Some team collaboration experience\",\"Familiarity with project tools (preferred)\"]', '[\"Master Agile and Scrum methodologies\",\"Develop effective resource planning skills\",\"Learn advanced team coordination techniques\",\"Implement project risk management strategies\",\"Use project management tools effectively\",\"Achieve PMP\\/Scrum Master certification readiness\"]', 'Week 1: Project Management Fundamentals & Frameworks\nWeek 2: Agile & Scrum Methodologies\nWeek 3: Resource Planning & Budget Management\nWeek 4: Risk Management & Quality Assurance\nWeek 5: Team Leadership & Stakeholder Communication', 'completion', 30, 10, 0, '2025-09-08 04:54:56', '2025-09-22 04:54:56', '2025-09-26 04:54:56', '2025-10-31 04:54:56', '{\"days\":[\"Wednesday\",\"Friday\"],\"time\":\"10:00-13:00\",\"timezone\":\"EST\"}', 'America/New_York', 'physical', 'AMEX Project Management Institute', '200 Vesey Street, Training Room C Floor 12, New York, NY 10281', NULL, 'James Thompson', 'james.thompson@amex.com', 'PMP Certified Project Manager with 18+ years experience. Former Director of PMO at Fortune 500 companies.', 4, '[\"Project Management Toolkit\",\"Agile Templates Library\",\"Case Study Examples\",\"Certification Prep Materials\"]', '[\"PMI Standards and Guidelines\",\"Scrum.org Resources\",\"Project Management Software Trials\",\"Professional Community Access\"]', 'published', 1, 0, 0, 'Project Management Mastery - Agile & Traditional Methods', 'Comprehensive project management training covering Agile, Scrum, and traditional methodologies. 5-week intensive program.', 'courses/thumbnails/project-management.jpg', '[\"Project Management\",\"Agile\",\"Scrum\",\"Planning\",\"Leadership\"]', '[\"Project Management\",\"IT\",\"Operations\",\"Marketing\"]', '[\"Project Manager\",\"Scrum Master\",\"Team Lead\",\"Product Manager\"]', '[\"mid\",\"senior\"]', 0, 4.60, 67, 278, 34, 29, '2025-08-28 23:24:56', '2025-08-28 23:24:56'),
(57, 'Data Privacy & GDPR Compliance', 'Understanding data protection regulations and compliance requirements. Comprehensive training on GDPR, CCPA, and other privacy laws affecting modern businesses.', 'data-privacy-gdpr-compliance', 'compliance', 'in-person', 'essential', 3, 24, 399.00, '[\"Basic understanding of data handling\",\"Familiarity with business processes\",\"No prior legal knowledge required\"]', '[\"Understand GDPR and privacy law requirements\",\"Implement data protection measures\",\"Conduct privacy impact assessments\",\"Handle data subject requests effectively\",\"Ensure compliance across business operations\",\"Manage data breach response procedures\"]', 'Week 1: Introduction to Data Privacy Laws & GDPR Fundamentals\nWeek 2: Implementation Strategies & Data Protection Measures\nWeek 3: Compliance Monitoring & Breach Response', 'completion', 50, 15, 1, '2025-09-03 04:54:56', '2025-09-17 04:54:56', '2025-09-19 04:54:56', '2025-10-10 04:54:56', '{\"days\":[\"Monday\",\"Wednesday\",\"Friday\"],\"time\":\"11:00-13:00\",\"timezone\":\"EST\"}', 'America/New_York', 'physical', 'AMEX Legal Compliance Center', '200 Vesey Street, Legal Department Floor 18, New York, NY 10281', NULL, 'Laura Williams', 'laura.williams@amex.com', 'Data Privacy Attorney and CIPP/E certified professional. 10+ years experience in privacy law and GDPR implementation.', 5, '[\"GDPR Compliance Handbook\",\"Privacy Policy Templates\",\"Compliance Checklists\",\"Legal Updates Newsletter\"]', '[\"EU GDPR Official Text\",\"Privacy Authority Guidelines\",\"Industry Best Practices\",\"Compliance Software Tools\"]', 'published', 1, 0, 1, 'Data Privacy & GDPR Compliance Training - Essential Knowledge', 'Essential GDPR and data privacy compliance training. Learn regulations, implementation, and best practices in 3 weeks.', 'courses/thumbnails/data-privacy.jpg', '[\"GDPR\",\"Data Privacy\",\"Compliance\",\"Legal\",\"Data Protection\"]', '[\"Legal\",\"IT\",\"HR\",\"Marketing\",\"All Departments\"]', '[\"Data Protection Officer\",\"Compliance Manager\",\"IT Manager\",\"All Employees\"]', '[\"junior\",\"mid\",\"senior\"]', 0, 4.30, 89, 445, 78, 71, '2025-08-28 23:24:56', '2025-08-28 23:24:56'),
(58, 'Effective Communication Skills', 'Effective communication, presentation skills, and active listening techniques. Develop professional communication abilities for enhanced workplace collaboration and leadership.', 'effective-communication-skills', 'soft-skills', 'in-person', 'beginner', 4, 32, 499.00, '[\"No prior experience required\",\"Willingness to participate in group activities\",\"Basic English proficiency\"]', '[\"Master verbal and non-verbal communication\",\"Develop confident presentation skills\",\"Practice active listening techniques\",\"Improve written communication clarity\",\"Handle difficult conversations effectively\",\"Build professional networking abilities\"]', 'Week 1: Communication Fundamentals & Active Listening\nWeek 2: Presentation Skills & Public Speaking\nWeek 3: Written Communication & Digital Etiquette\nWeek 4: Difficult Conversations & Conflict Resolution', 'completion', 25, 12, 0, '2025-09-01 04:54:56', '2025-09-15 04:54:56', '2025-09-19 04:54:56', '2025-10-17 04:54:56', '{\"days\":[\"Tuesday\",\"Thursday\"],\"time\":\"16:00-18:00\",\"timezone\":\"EST\"}', 'America/New_York', 'physical', 'AMEX Communication Skills Lab', '200 Vesey Street, Professional Development Center Floor 8, New York, NY 10281', NULL, 'Dr. Patricia Garcia', 'patricia.garcia@amex.com', 'Communication specialist and certified executive coach. Former corporate trainer with 14+ years experience in professional development.', 6, '[\"Communication Skills Workbook\",\"Presentation Templates\",\"Practice Exercise Library\",\"Self-Assessment Tools\"]', '[\"TED Talks on Communication\",\"Professional Speaking Resources\",\"Writing Style Guides\",\"Communication Apps and Tools\"]', 'published', 1, 0, 0, 'Effective Communication Skills - Professional Development', 'Improve communication, presentation, and listening skills. 4-week practical training for workplace success.', 'courses/thumbnails/communication-skills.jpg', '[\"Communication\",\"Presentation\",\"Soft Skills\",\"Professional Development\"]', '[\"All Departments\"]', '[\"All Roles\",\"New Employees\",\"Team Members\"]', '[\"junior\",\"mid\"]', 0, 4.40, 123, 567, 89, 76, '2025-08-28 23:24:56', '2025-08-28 23:24:56');

-- --------------------------------------------------------

--
-- Table structure for table `course_feedbacks`
--

CREATE TABLE `course_feedbacks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `enrollment_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rating` int(10) UNSIGNED NOT NULL DEFAULT 5,
  `feedback` text NOT NULL,
  `categories` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`categories`)),
  `is_anonymous` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_response` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_sessions`
--

CREATE TABLE `course_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `session_date` datetime NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `meeting_link` varchar(255) DEFAULT NULL,
  `recording_link` varchar(255) DEFAULT NULL,
  `session_type` enum('live','recorded','assignment','quiz') NOT NULL DEFAULT 'live',
  `status` enum('scheduled','ongoing','completed','cancelled') NOT NULL DEFAULT 'scheduled',
  `notes` text DEFAULT NULL,
  `materials` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`materials`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `trainee_name` varchar(255) NOT NULL,
  `trainee_email` varchar(255) NOT NULL,
  `reference_id` varchar(13) DEFAULT NULL,
  `trainee_phone` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `education_level` varchar(255) NOT NULL,
  `trainee_address` text NOT NULL,
  `previous_experience` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `enrollment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `course_id`, `trainee_name`, `trainee_email`, `reference_id`, `trainee_phone`, `date_of_birth`, `gender`, `education_level`, `trainee_address`, `previous_experience`, `status`, `enrollment_date`, `created_at`, `updated_at`) VALUES
(1, 53, 'miyulas', 'miyulasbandara@gmail.com', 'AMX2508290001', '0765432345', '2000-11-11', 'male', 'High School', 'moneragala,welewatta.', 'expert in js and python', 'approved', '2025-08-29 02:28:30', '2025-08-29 02:28:30', '2025-08-29 02:29:17');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_05_081027_add_two_factor_columns_to_users_table', 1),
(5, '2025_08_05_081114_create_personal_access_tokens_table', 1),
(6, '2025_08_05_081627_courses', 1),
(7, '2025_08_08_090144_add_two_factor_columns_to_users_table', 1),
(8, '2025_08_08_090315_add_profile_features_to_users_table', 1),
(9, '2025_08_10_084132_create_enrollments_table', 1),
(10, '2025_08_16_100654_create_sessions_table', 2),
(11, '2025_08_16_143739_create_course_feedbacks_table', 2),
(12, '2025_08_21_033348_create_trainers_table', 2),
(13, '2025_08_21_035444_add_trainer_fields_to_users_table', 3),
(14, '2025_08_22_074035_add_missing_columns_to_trainers_table', 4),
(17, '2025_08_22_083412_add_missing_trainer_data_to_trainers_table', 5),
(18, '2025_08_22_140930_add_role_and_is_trainer_to_trainers_table', 5),
(19, '2025_08_22_150853_remove_user_id_from_trainers_table', 6),
(20, '2025_08_27_020414_add_reference_id_to_users_table', 7),
(21, '2025_08_27_020710_add_reference_id_to_enrollments_table', 8),
(22, '2025_08_28_034307_add_user_id_to_trainers_table', 9),
(23, '2025_08_28_090254_add_user_type_to_users_table', 10),
(24, '2025_09_03_023009_create_admins_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `trainer_name` varchar(255) NOT NULL,
  `trainer_mail` varchar(255) NOT NULL,
  `trainer_password` varchar(255) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `experience_years` int(11) NOT NULL DEFAULT 0,
  `hourly_rate` decimal(8,2) DEFAULT NULL,
  `max_courses_per_month` int(11) DEFAULT NULL,
  `certifications` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`certifications`)),
  `phone` varchar(255) DEFAULT NULL,
  `linkedin_profile` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'trainee',
  `is_trainer` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`id`, `user_id`, `trainer_name`, `trainer_mail`, `trainer_password`, `employee_id`, `department`, `bio`, `specialization`, `experience_years`, `hourly_rate`, `max_courses_per_month`, `certifications`, `phone`, `linkedin_profile`, `is_active`, `created_at`, `updated_at`, `role`, `is_trainer`) VALUES
(20, 62, 'Michael Rodriguez', 'michael.rodriguez@amex.com', '$2y$12$BV3o1ou9IjNVw36HbK/FxOpGmQa4BmRKl/PVH.kSGfl3JoqH9GOKa', 'TR0002', 'Security Department', 'Certified Information Security Manager (CISM) with 15+ years in cybersecurity.', 'Cybersecurity & Information Security', 15, 95.00, 4, '\"[\\\"Professional Certification\\\",\\\"Advanced Training\\\"]\"', '+1-555-0002', 'https://linkedin.com/in/michaelrodriguez', 1, '2025-08-22 09:43:24', '2025-08-28 03:56:41', 'trainer', 1),
(21, 63, 'Dr. Amanda Foster', 'amanda.foster@amex.com', '$2y$12$JRq6UMeG52c14LlMbXqKFOeIqb5fMGuWA7eukN5iyQJhvqm5sHQBm', 'TR0003', 'Human Resources', 'Former McKinsey Partner and Harvard Business School professor.', 'Leadership & Organizational Development', 20, 120.00, 3, '\"[\\\"Professional Certification\\\",\\\"Advanced Training\\\"]\"', '+1-555-0003', 'https://linkedin.com/in/dr.amandafoster', 1, '2025-08-22 09:43:24', '2025-08-28 03:56:42', 'trainer', 1),
(22, 64, 'James Thompson', 'james.thompson@amex.com', '$2y$12$JUFExTse5wh4TAa1d0vqOeAZ1XrM.Srj1fiP8NrjghnYRTpaDYLuO', 'TR0004', 'Operations Department', 'PMP Certified Project Manager with 18+ years experience.', 'Project Management & Operations', 18, 80.00, 5, '\"[\\\"Professional Certification\\\",\\\"Advanced Training\\\"]\"', '+1-555-0004', 'https://linkedin.com/in/jamesthompson', 1, '2025-08-22 09:43:25', '2025-08-28 03:56:43', 'trainer', 1),
(23, 65, 'Laura Williams', 'laura.williams@amex.com', '$2y$12$sGKFXGXnsxXg1lCBeCZ4FuN4bM9NiKFGvKKKvuyvNzwmkDgEneek2', 'TR0005', 'Legal & Compliance', 'Data Privacy Attorney and CIPP/E certified professional.', 'Data Privacy & Compliance', 10, 90.00, 4, '\"[\\\"Professional Certification\\\",\\\"Advanced Training\\\"]\"', '+1-555-0005', 'https://linkedin.com/in/laurawilliams', 1, '2025-08-22 09:43:25', '2025-08-28 03:56:43', 'trainer', 1),
(24, NULL, 'Dr. Patricia Garcia', 'patricia.garcia@amex.com', '$2y$12$r4O2RggSJ2jXTgPSi.xfd.q0V2vGqWWyFU59XYWkeqguKZ5hFQhr6', 'TR0006', 'Training & Development', 'Communication specialist and certified executive coach. Former corporate trainer with 14+ years experience in professional development.', 'Communication & Professional Development', 14, 95.00, 8, '\"ICF Associate Certified Coach, Dale Carnegie Certified, PhD in Communications\"', '+1-555-0006', 'https://linkedin.com/in/patriciagarcia', 1, '2025-08-22 09:43:25', '2025-08-22 09:43:25', 'trainer', 1),
(25, 61, 'Dr. Sarah Chen', 'sarah.chen@amex.com', '$2y$12$FhtO90W2koubGK4JF4TxmeupRjto7y1ZCr4vF2LZ60anwvztwtDh6', 'TR0001', 'Technology Department', 'Senior Software Architect with 12+ years experience in full-stack development.', 'Full-Stack Development', 12, 85.00, 6, '\"[\\\"Professional Certification\\\",\\\"Advanced Training\\\"]\"', '+1-555-0001', 'https://linkedin.com/in/dr.sarahchen', 1, '2025-08-28 03:53:13', '2025-08-28 03:56:40', 'trainer', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_type` enum('admin','trainer','employee') NOT NULL DEFAULT 'employee',
  `reference_id` varchar(13) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'trainee',
  `is_trainer` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `user_type`, `reference_id`, `role`, `is_trainer`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(61, 'Dr. Sarah Chen', 'sarah.chen@amex.com', 'trainer', NULL, 'trainee', 0, '2025-08-28 03:56:40', '$2y$12$UgdQUfVkUzBub0kV/gsoPuoS3ax75FFZPZ/sKqX7UPmSpktWHLB5y', NULL, NULL, NULL, 'cfrhpJGmM8j6LN1GtkNRikhzj4eQGaq0m32j5S1JFzrGENlZr6s3CEi5DRpv', NULL, NULL, '2025-08-28 03:34:32', '2025-08-28 03:56:40'),
(62, 'Michael Rodriguez', 'michael.rodriguez@amex.com', 'trainer', NULL, 'trainee', 0, '2025-08-28 03:56:41', '$2y$12$322GY1VkfgQmbyo/953fKe5Eh3xGMtELm.Zi/wMGRzR8xg69qWu6.', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-28 03:53:14', '2025-08-28 03:56:41'),
(63, 'Dr. Amanda Foster', 'amanda.foster@amex.com', 'trainer', NULL, 'trainee', 0, '2025-08-28 03:56:41', '$2y$12$ymaiIe/zPQXmNrDBE4h8R.Q82PYEFLjNkVxjpyuzlRTLes/OIJ9Ei', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-28 03:56:41', '2025-08-28 03:56:41'),
(64, 'James Thompson', 'james.thompson@amex.com', 'trainer', NULL, 'trainee', 0, '2025-08-28 03:56:42', '$2y$12$qweKOuzM33vVw25JD0j8Jevj/f.hW1h0RuHsNv.81ul7cWnZ1o7Iq', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-28 03:56:42', '2025-08-28 03:56:42'),
(65, 'Laura Williams', 'laura.williams@amex.com', 'trainer', NULL, 'trainee', 0, '2025-08-28 03:56:43', '$2y$12$XyF6qxPoDFUXMv90B0Pfyu09EZR.bEQY6GyLYmiggHt0v8bPz9T/y', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-28 03:56:43', '2025-08-28 03:56:43'),
(76, 'System Administrator', 'admin@example.com', 'employee', NULL, 'trainee', 0, '2025-09-02 22:23:17', '$2y$12$3Gy0LOMTAeX5.IY87ViJI.W.Cft81PK19B1I1R59qVHpu5MI0Un9u', NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-02 22:23:17', '2025-09-02 22:23:17'),
(77, 'Miyulas Bandar', 'miyulasbandara@gmail.com', 'employee', NULL, 'trainee', 0, NULL, '$2y$12$TpKKnfmfyoGV0GgQNoH5b.grGB//AqG22CTDmpJlNbtV54PZNSlm2', NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-02 22:30:11', '2025-09-02 22:34:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admins_created_by_foreign` (`created_by`),
  ADD KEY `admins_user_id_index` (`user_id`),
  ADD KEY `admins_access_level_index` (`access_level`),
  ADD KEY `admins_is_active_index` (`is_active`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_slug_unique` (`slug`),
  ADD KEY `courses_category_index` (`category`),
  ADD KEY `courses_course_type_index` (`course_type`),
  ADD KEY `courses_difficulty_level_index` (`difficulty_level`),
  ADD KEY `courses_status_index` (`status`),
  ADD KEY `courses_is_active_index` (`is_active`),
  ADD KEY `courses_is_featured_index` (`is_featured`),
  ADD KEY `courses_trainer_id_index` (`trainer_id`),
  ADD KEY `courses_lecturer_name_index` (`lecturer_name`);

--
-- Indexes for table `course_feedbacks`
--
ALTER TABLE `course_feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_feedbacks_user_id_course_id_unique` (`user_id`,`course_id`),
  ADD KEY `course_feedbacks_enrollment_id_foreign` (`enrollment_id`),
  ADD KEY `course_feedbacks_course_id_status_index` (`course_id`,`status`),
  ADD KEY `course_feedbacks_user_id_created_at_index` (`user_id`,`created_at`),
  ADD KEY `course_feedbacks_rating_index` (`rating`);

--
-- Indexes for table `course_sessions`
--
ALTER TABLE `course_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_sessions_course_id_session_date_index` (`course_id`,`session_date`),
  ADD KEY `course_sessions_course_id_status_index` (`course_id`,`status`),
  ADD KEY `course_sessions_session_date_index` (`session_date`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enrollments_reference_id_unique` (`reference_id`),
  ADD KEY `enrollments_course_id_status_index` (`course_id`,`status`),
  ADD KEY `enrollments_trainee_email_index` (`trainee_email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trainers_employee_id_unique` (`employee_id`),
  ADD KEY `trainers_is_active_index` (`is_active`),
  ADD KEY `trainers_specialization_index` (`specialization`),
  ADD KEY `trainers_employee_id_index` (`employee_id`),
  ADD KEY `trainers_department_index` (`department`),
  ADD KEY `trainers_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_reference_id_unique` (`reference_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `course_feedbacks`
--
ALTER TABLE `course_feedbacks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_sessions`
--
ALTER TABLE `course_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `admins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_feedbacks`
--
ALTER TABLE `course_feedbacks`
  ADD CONSTRAINT `course_feedbacks_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_feedbacks_enrollment_id_foreign` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_feedbacks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_sessions`
--
ALTER TABLE `course_sessions`
  ADD CONSTRAINT `course_sessions_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trainers`
--
ALTER TABLE `trainers`
  ADD CONSTRAINT `trainers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
