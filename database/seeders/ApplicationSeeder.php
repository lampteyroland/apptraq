<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Application;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create the test user
        $testUser = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // Assign 50 applications to test user
        Application::factory(200)->create([
            'user_id' => $testUser->id,
        ]);

        // 2. Create 3 more users, each with 50 applications
        User::factory(3)->create()->each(function ($user) {
            Application::factory(50)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
