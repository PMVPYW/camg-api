<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ZonaEspetaculo>
 */
class ZonaEspetaculoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name,
            'prova_id' => $this->faker->numberBetween(),
            'nivel_afluencia' => $this->faker->randomElement(['Baixo', 'Médio', 'Alto']),
            'facilidade_acesso' => $this->faker->randomElement(['Fácil', 'Médio', 'Difícil']),
            'nivel_ocupacao' => $this->faker->randomElement(['Livre', 'Intermédio', 'Completo']),
            'info' => $this->faker->text(),
            'distancia_estacionamento' => $this->faker->numberBetween(),
            'coordenadas' => $this->faker->text(),


        ];
    }
}
