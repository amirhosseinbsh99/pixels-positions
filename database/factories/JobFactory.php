<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;  // Import User model instead of Employer
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Create a user with user_type 'employer'
            'employer_id' => User::factory()->state([
                'user_type' => 'employer',
            ]),
            'title' => fake()->jobTitle(),
            'category_id' => Category::factory(),
            'salary' => fake()->numberBetween(50000, 150000),
            'location' => 'remote',
            'schedule' => 'Full Time',
            'featured' => false,
        ];
    }
}
