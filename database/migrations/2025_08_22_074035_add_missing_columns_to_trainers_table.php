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
        Schema::table('trainers', function (Blueprint $table) {
            $table->string('employee_id')->unique()->after('user_id');
            $table->string('department')->nullable()->after('employee_id');
            $table->decimal('hourly_rate', 8, 2)->nullable()->after('experience_years');
            $table->integer('max_courses_per_month')->nullable()->after('hourly_rate');
            
            // Add indexes for the new columns
            $table->index('employee_id');
            $table->index('department');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainers', function (Blueprint $table) {
            $table->dropIndex(['employee_id']);
            $table->dropIndex(['department']);
            $table->dropColumn(['employee_id', 'department', 'hourly_rate', 'max_courses_per_month']);
        });
    }
};