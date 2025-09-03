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
        Schema::create('trainers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('employee_id')->unique();
            $table->string('department')->nullable();
            $table->text('bio')->nullable();
            $table->string('specialization')->nullable();
            $table->string('phone')->nullable();
            $table->integer('experience_years')->default(0);
            $table->boolean('is_active')->default(true);
            $table->decimal('hourly_rate', 8, 2)->nullable();
            $table->integer('max_courses_per_month')->nullable();
            $table->json('certifications')->nullable();
            $table->string('linkedin_profile')->nullable();
            $table->timestamps();

            // Add indexes
            $table->index('user_id');
            $table->index('employee_id');
            $table->index('is_active');
            $table->index('specialization');
            $table->index('department');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainers');
    }
};