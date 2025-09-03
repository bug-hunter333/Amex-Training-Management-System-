
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('slug')->unique();
            $table->string('category');
            $table->string('course_type');
            $table->string('difficulty_level');
            $table->integer('duration_weeks');
            $table->integer('duration_hours');
            $table->decimal('price', 8, 2);
            $table->json('prerequisites');
            $table->json('learning_objectives');
            $table->text('course_outline');
            $table->string('certificate_type');
            $table->integer('max_participants');
            $table->integer('min_participants');
            $table->boolean('auto_enrollment')->default(false);
            $table->datetime('enrollment_start_date');
            $table->datetime('enrollment_end_date');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->json('schedule');
            $table->string('timezone');
            $table->string('venue_type');
            $table->string('venue_name')->nullable();
            $table->string('venue_address')->nullable();
            $table->string('online_platform')->nullable();
            
            // Lecturer Information Fields
            $table->string('lecturer_name')->nullable();
            $table->string('lecturer_email')->nullable();
            $table->text('lecturer_bio')->nullable();
            
            $table->unsignedBigInteger('trainer_id');
            $table->json('materials');
            $table->json('resources');
            $table->string('status');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_mandatory')->default(false);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('tags');
            $table->json('target_departments');
            $table->json('target_roles');
            $table->json('target_levels');
            $table->boolean('requires_approval')->default(false);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            $table->integer('view_count')->default(0);
            $table->integer('enrollment_count')->default(0);
            $table->integer('completion_count')->default(0);
            $table->timestamps();
            // Add indexes for better performance
            $table->index('category');
            $table->index('course_type');
            $table->index('difficulty_level');
            $table->index('status');
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('trainer_id');
            $table->index('lecturer_name'); // Added index for lecturer search
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
