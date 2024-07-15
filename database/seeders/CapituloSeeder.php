<?php

namespace Database\Seeders;

use App\Models\Capitulo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CapituloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Capitulo::factory()->create([
            "historia_id" => 2,
            "titulo" => "RALLYE VIDREIRO",
        ]);

        Capitulo::factory()->create([
            "historia_id" => 2,
            "titulo" => "PROVAS DOS TROFÉUS REGIONAIS",
        ]);

        Capitulo::factory()->create([
            "historia_id" => 2,
            "titulo" => "RALLYE ROTA DO SOL",
        ]);
    }
}
