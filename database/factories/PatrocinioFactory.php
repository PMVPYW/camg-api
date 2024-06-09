<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patrocinio>
 */
class PatrocinioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'entidade_id' => null,
            'rally_id' => null,
            'relevancia' => $this->faker->numberBetween(1,10),
            'entidade_oficial' => $this->faker->numberBetween(0,1)
        ];
    }
}
