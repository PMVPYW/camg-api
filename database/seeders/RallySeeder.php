<?php

namespace Database\Seeders;

use App\Models\Rally;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class RallySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $fileName = CommonSeederFunctions::storePhoto("vidreiro.jpeg");
        Rally::factory()->create([
            "nome" => "Rally Vidreiro 2024",
            "data_inicio" => "2024-10-11",
            "data_fim" => "2024-10-12",
            "photo_url" => $fileName,
            "external_entity_id" => "111"
        ]);

        $fileName = CommonSeederFunctions::storePhoto("ourem.jpg");
        Rally::factory()->create([
            "nome" => "Rally Terras de Auren 2024",
            "data_inicio" => "2024-4-19",
            "data_fim" => "2024-4-20",
            "photo_url" => $fileName,
            "external_entity_id" => "141"
        ]);
    }
}
