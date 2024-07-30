<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ConselhoSeguranca>
 */
class ConselhoSegurancaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'descricao' => $this->faker->text(),
            "erro" => $this->faker->text(),
            "img_conselho" => null,
            "img_erro" => null
        ];
    }
}
