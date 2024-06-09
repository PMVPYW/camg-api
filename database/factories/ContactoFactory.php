<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contacto>
 */
class ContactoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tipocontacto_id' => null,
            'tipo_valor' => $this->faker->randomElement(['Email', 'Telemovel', 'Telefone', 'Fax', 'Facebook', 'Instagram', 'Twitter', 'PaginaWeb', 'WhatsApp', 'Morada', 'Coordenadas']),
            'valor' => $this->faker->text,
            'nome' => $this->faker->name,
        ];
    }
}
