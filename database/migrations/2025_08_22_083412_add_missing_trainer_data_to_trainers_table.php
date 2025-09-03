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
            if (!Schema::hasColumn('trainers', 'trainer_name')) {
                $table->string('trainer_name')->after('id');
            }

            if (!Schema::hasColumn('trainers', 'trainer_mail')) {
                $table->string('trainer_mail')->unique()->after('trainer_name');
            }

            if (!Schema::hasColumn('trainers', 'trainer_password')) {
                $table->string('trainer_password')->after('trainer_mail');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainers', function (Blueprint $table) {
            if (Schema::hasColumn('trainers', 'trainer_name')) {
                $table->dropColumn('trainer_name');
            }
            if (Schema::hasColumn('trainers', 'trainer_mail')) {
                $table->dropColumn('trainer_mail');
            }
            if (Schema::hasColumn('trainers', 'trainer_password')) {
                $table->dropColumn('trainer_password');
            }
        });
    }
};
