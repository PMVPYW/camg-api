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
        $fileName = $this->storePhoto("vidreiro.jpeg");
        Rally::factory()->create([
            "nome" => "Rally Vidreiro 2024",
            "data_inicio" => "2024-10-11",
            "data_fim" => "2024-10-12",
            "photo_url" => $fileName,
            "external_entity_id" => "111"
        ]);

        $fileName = $this->storePhoto("ourem.jpg");
        Rally::factory()->create([
            "nome" => "Rally Terras de Auren 2024",
            "data_inicio" => "2024-4-19",
            "data_fim" => "2024-4-20",
            "photo_url" => $fileName,
            "external_entity_id" => "111"
        ]);
    }

    protected function storePhoto($name)
        {
            $n_array = explode('.', $name);
            $file_type = $n_array[count($n_array) - 1];
            $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
            File::copy("database/seeders/fotos/" . $name, storage_path('app/public/fotos/' . $file_name_to_store));
            return $file_name_to_store;
        }
}
