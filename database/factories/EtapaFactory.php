<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Etapa>
 */
class EtapaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "capitulo_id" => $this->faker->numberBetween(),
            "nome" => $this->faker->name(),
            "ano_inicio" => $this->faker->numberBetween(1000, 9999),
            "ano_fim" => null,
        ];
    }
}
