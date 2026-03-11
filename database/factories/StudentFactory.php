<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\RaceColor;
use App\Enums\Gender;
use App\Enums\Ser;
use App\Enums\EducationLevel;
use App\Models\Student;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //'registration_number' => Student::generateRegistrationNumber(),
            'name' => fake()->firstName() . ' ' . fake()->lastName(),
            'nationality' => 'Brasileira',
            'birthplace' => fake('pt_BR')->city(),
            'birthdate' => fake()->dateTimeBetween('-60 years', '-10 years'),
            'gender' => fake()->randomElement(Gender::cases()),
            'race_color' => fake()->randomElement(RaceColor::cases()),
            'ser' => fake()->randomElement(Ser::cases()),
            'education_level' => fake()->randomElement(EducationLevel::cases())
        ];
    }
}
