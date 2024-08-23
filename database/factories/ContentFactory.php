<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => 15,
            'type_id' => 15,
            'parent_id' => 2,
            'user_id' => 2,
            'content_title' => fake()->name(),
            'seo_title' => fake()->name(),
            'seo_description' => fake()->name(),
            'seo_keywords' => fake()->name(),
            'content_body' => fake()->paragraph(30),
            'status' => rand(1,0),
        ];
    }
}
