<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Foto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $album = Album::query()->orderBy('id', 'asc')->first();
        for ($i = 1; $i < 11; $i++) {
            $fileName = CommonSeederFunctions::storePhoto($i . ".jpg");
            Foto::factory()->create(["album_id" => $album->id, "image_src" => $fileName, "description" => "rally_vidreiro"]);
        }
        $album = Album::query()->where('nome',  "Rally terras de Auren")->first();
        $fileName = CommonSeederFunctions::storePhoto("cartaz_ourem.jpg");
        Foto::factory()->create(["album_id" => $album->id, "image_src" => $fileName, "description" => "rally_ourem"]);
    }
}
