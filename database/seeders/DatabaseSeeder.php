<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // courses::class,
            // SessionSeeder::class,
            // CourseFeedbackSeeder::class,
            // TestDataSeeder::class,
            // TrainerUserSeeder::class,
             AdminSeeder::class,
        ]);
    }
}
