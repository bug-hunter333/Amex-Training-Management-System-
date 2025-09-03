<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\CourseFeedback;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CourseFeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all enrollments that could have feedback
        $enrollments = Enrollment::with(['user', 'course'])
            ->where('status', 'enrolled')
            ->get();

        $feedbackTexts = [
            1 => [
                "The course was very disappointing. The content was outdated and the instructor seemed unprepared.",
                "Not satisfied with the quality. Expected much more from this course.",
                "Poor delivery and lack of practical examples made this course hard to follow."
            ],
            2 => [
                "The course was okay but could be improved. Some sections were unclear.",
                "Average course with basic content. Nothing exceptional but covers the fundamentals.",
                "It was fine but I expected more interactive sessions and better materials."
            ],
            3 => [
                "Good course overall with solid content. The instructor was knowledgeable.",
                "Pretty good course that covered the topics well. Materials were helpful.",
                "Decent course with good examples. Would recommend for beginners."
            ],
            4 => [
                "Very good course! Well-structured content and excellent instructor.",
                "Really enjoyed this course. Great balance of theory and practical work.",
                "Excellent materials and clear explanations. Learned a lot from this course."
            ],
            5 => [
                "Outstanding course! Exceeded all my expectations. Highly recommend!",
                "Perfect course with amazing instructor and top-quality materials.",
                "Exceptional learning experience. This course is a must-take for anyone interested in the subject.",
                "Absolutely brilliant! The best course I've ever taken. Five stars!"
            ]
        ];

        $categories = [
            ['content', 'overall'],
            ['instructor', 'delivery'],
            ['materials', 'support'],
            ['content', 'instructor', 'overall'],
            ['delivery', 'materials'],
            ['content', 'instructor', 'delivery', 'materials', 'support', 'overall']
        ];

        foreach ($enrollments as $enrollment) {
            // Only create feedback for about 70% of enrollments
            if ($faker->boolean(70)) {
                // Determine rating (weighted towards higher ratings)
                $rating = $faker->randomElement([1, 2, 3, 3, 4, 4, 4, 5, 5, 5]);
                
                // Select appropriate feedback text based on rating
                $feedbackText = $faker->randomElement($feedbackTexts[$rating]);
                
                // Add some variation to the feedback text
                $feedbackText .= " " . $faker->sentence();

                // Check if feedback already exists
                $existingFeedback = CourseFeedback::where('user_id', $enrollment->user_id)
                    ->where('course_id', $enrollment->course_id)
                    ->first();

                if (!$existingFeedback) {
                    CourseFeedback::create([
                        'user_id' => $enrollment->user_id,
                        'course_id' => $enrollment->course_id,
                        'enrollment_id' => $enrollment->id,
                        'username' => $enrollment->user->name,
                        'email' => $enrollment->user->email,
                        'rating' => $rating,
                        'feedback' => $feedbackText,
                        'categories' => $faker->randomElement($categories),
                        'is_anonymous' => $faker->boolean(20), // 20% anonymous
                        'status' => $faker->randomElement(['approved', 'approved', 'approved', 'pending']), // Mostly approved
                        'admin_response' => $faker->boolean(30) ? $faker->sentence() : null, // 30% have admin responses
                        'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                    ]);
                }
            }
        }

        // Update course ratings after seeding
        $courses = Course::all();
        foreach ($courses as $course) {
            $this->updateCourseRating($course->id);
        }

        $this->command->info('Course feedback seeded successfully!');
    }

    /**
     * Update course average rating and review count
     */
    private function updateCourseRating($courseId): void
    {
        $course = Course::find($courseId);
        if (!$course) return;

        $approvedFeedbacks = CourseFeedback::where('course_id', $courseId)
            ->where('status', 'approved');

        $averageRating = $approvedFeedbacks->avg('rating') ?: 0;
        $totalReviews = $approvedFeedbacks->count();

        // Only update if the course has the rating columns
        try {
            $course->update([
                'average_rating' => round($averageRating, 2),
                'total_reviews' => $totalReviews
            ]);
        } catch (\Exception $e) {
            // If columns don't exist, skip updating
            $this->command->warn("Could not update rating for course {$courseId}: " . $e->getMessage());
        }
    }
}