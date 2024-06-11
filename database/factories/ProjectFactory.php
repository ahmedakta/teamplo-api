<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_name' => fake()->name(),
            'department_id' => rand(1, 10),
            'project_description' => fake()->paragraph(1),
            'project_start_at' => fake()->dateTime(),
            'project_end_at' => fake()->dateTime(),
            'project_budget' => fake()->randomDigit(),
            'project_priority' => rand(7,9),
            'project_stage' => rand(3,6),
            'status' => rand(1,0),
        ];
    }
}
