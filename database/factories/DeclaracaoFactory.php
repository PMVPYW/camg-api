<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Declaracao>
 */
class DeclaracaoFactory extends Factory
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
            "conteudo" => $this->faker->text(),
            'nome' => $this->faker->name(),
            'photo_url' => null,
            'cargo' => $this->faker->text(),
            'entidade_equipa' => null,
            'pontos'=>null
        ];
    }
}
