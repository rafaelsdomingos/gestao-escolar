<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\RaceColor;

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
            'name' => fake()->firstName() . ' ' . fake()->lastName(),
            'nationality' => 'Brasileira',
            'birthplace' => fake('pt_BR')->city(),
            'birthdate' => fake()->dateTimeBetween('-60 years', '-10 years'),
            'gender' => fake()->randomElement([
                'Masculino',
                'Feminino',
                'Não-binário',
                'Prefiro não informar',
            ]),
            'race_color' => fake()->randomElement(RaceColor::cases()),
        ];
    }
}
