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
        Schema::create('course_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('enrollment_id')->constrained()->onDelete('cascade');
            $table->string('username');
            $table->string('email');
            $table->integer('rating')->unsigned()->default(5); // 1-5 star rating
            $table->text('feedback');
            $table->json('categories')->nullable(); // For feedback categories like content, instructor, delivery, etc.
            $table->boolean('is_anonymous')->default(false);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_response')->nullable();
            $table->timestamps();
            
            // Ensure one feedback per user per course
            $table->unique(['user_id', 'course_id']);
            
            // Indexes for better performance
            $table->index(['course_id', 'status']);
            $table->index(['user_id', 'created_at']);
            $table->index('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_feedbacks');
    }
};