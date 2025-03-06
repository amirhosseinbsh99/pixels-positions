<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),  // Ensure the name is unique
            'parent_id' => null, // Set to null for top-level categories
        ];
    }

    /**
     * Define the model's state with a parent category.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withParent()
    {
        return $this->state(function (array $attributes) {
            return [
                'parent_id' => Category::factory(), // Automatically creates a parent category
            ];
        });
    }
}
