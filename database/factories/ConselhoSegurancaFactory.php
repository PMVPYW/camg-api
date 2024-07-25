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
            'conselho' => null,
            "erro" => null,
            "conselho_img" => null,
            "erro_img" => null
        ];
    }
}
