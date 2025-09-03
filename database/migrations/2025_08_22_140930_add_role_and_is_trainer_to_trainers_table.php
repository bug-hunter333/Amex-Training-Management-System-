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
            if (!Schema::hasColumn('trainers', 'role')) {
                $table->string('role')->default('trainee'); // admin, trainer, trainee
            }

            if (!Schema::hasColumn('trainers', 'is_trainer')) {
                $table->boolean('is_trainer')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainers', function (Blueprint $table) {
            if (Schema::hasColumn('trainers', 'role')) {
                $table->dropColumn('role');
            }

            if (Schema::hasColumn('trainers', 'is_trainer')) {
                $table->dropColumn('is_trainer');
            }
        });
    }
};