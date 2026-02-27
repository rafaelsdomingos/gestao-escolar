<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\CourseModality;
use App\Models\AcademicCoordination;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'academic_coordination_id' => AcademicCoordination::factory(),
            'name' => fake('pt_BR')->sentence(3),
            'modality' => CourseModality::cases()[array_rand(CourseModality::cases())]->value,
            'description' => fake()->sentence(),
        ];
    }
}
