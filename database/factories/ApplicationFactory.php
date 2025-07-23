<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ApplicationFactory extends Factory
{
    public function definition(): array
    {
        $statuses = ['Wishlist', 'Applied', 'Interviewing', 'Offered', 'Rejected', 'Accepted'];
        $appliedDate = \Carbon\Carbon::create(2025, rand(1, 12), rand(1, 28));

        return [
            'user_id' => \App\Models\User::factory(),
            'company' => $this->faker->company,
            'position' => $this->faker->jobTitle,
            'status' => $this->faker->randomElement($statuses),
            'applied_on' => $appliedDate,
            'deadline' => $appliedDate->copy()->addDays(rand(7, 30)),
            'location' => $this->faker->city,
            'notes' => $this->faker->sentence,
            'job_link' => $this->faker->url,
            'resume_used' => 'resume.pdf',
        ];
    }

}
