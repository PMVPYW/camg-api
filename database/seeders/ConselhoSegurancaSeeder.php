<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Rally;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConselhoSegurancaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $errors = ["Não se distraia, não brinque com a sua segurança", ""];

        $fileName = CommonSeederFunctions::storePhoto("vidreiro.jpeg");
        Album::factory()->create([
            'nome' => "Rally Vidreiro",
            "img" => $fileName,
        ]);

        $fileName = CommonSeederFunctions::storePhoto("ourem.jpg");
        Album::factory()->create([
            'nome' => "Rally terras de Auren",
            "img" => $fileName,
        ]);
    }
}
