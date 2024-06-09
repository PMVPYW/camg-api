<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prova>
 */
class ProvaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "rally_id" => $this->faker->numberBetween(),
            "external_id" => $this->faker->numberBetween(),
            "local" => $this->faker->address(),
            "distancia_percurso" => $this->faker->numberBetween(),
            "horario_id" => null,
            "nome" => $this->faker->name
        ];
    }
}
