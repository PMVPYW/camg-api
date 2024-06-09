<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Horario>
 */
class HorarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rally_id' => null,
            'titulo' => $this->faker->word(),
            'descricao' => $this->faker->text(),
            'inicio' => $this->faker->dateTime(),
            'fim' => $this->faker->dateTime(),
        ];
    }
}
