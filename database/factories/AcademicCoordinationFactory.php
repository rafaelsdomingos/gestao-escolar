<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcademicCoordination>
 */
class AcademicCoordinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'code' => strtoupper(fake()->bothify('CUR-###')),
            'coordinator' => fake()->name(),
            'phone' => fake()->boolean(70)
                ? fake('pt_BR')->cellphoneNumber()
                : null,
            'email' => fake()->boolean(70)
                ? fake()->unique()->safeEmail()
                : null,
        ];
    }
}
