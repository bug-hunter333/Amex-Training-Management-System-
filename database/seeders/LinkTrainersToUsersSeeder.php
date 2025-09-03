<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Trainer;

class LinkTrainersToUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Loop through all trainers
        $trainers = Trainer::whereNull('user_id')->get();

        foreach ($trainers as $trainer) {
            // Find user by email (assuming trainer_mail matches user email)
            $user = User::where('email', $trainer->trainer_mail)->first();

            if ($user) {
                $trainer->user_id = $user->id;
                $trainer->save();
                $this->command->info("Linked Trainer {$trainer->trainer_name} to User {$user->email}");
            } else {
                $this->command->warn("No matching user found for Trainer {$trainer->trainer_name}");
            }
        }
    }
}
