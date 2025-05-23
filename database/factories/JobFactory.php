<?php

namespace Database\Factories;

use App\Models\Employer;
use App\Models\Category;

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
            'employer_id' => Employer::factory(),  // Use the factory directly
            'title' => fake()->jobTitle(),
            'category_id' => Category::factory(), // Use the factory directly
            'salary' => fake()->numberBetween(50000, 150000),
            'location' => 'remote',
            'schedule' => 'Full Time',
            'featured' => false,
        ];
    }
}
