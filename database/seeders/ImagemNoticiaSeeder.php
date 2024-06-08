<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Foto;
use App\Models\ImagemNoticia;
use App\Models\Noticia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImagemNoticiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $album = Album::query()->where('nome',  "Rally terras de Auren")->first();
        $foto_noticia = Foto::query()->where('album_id', $album->id)->first();

        foreach (Noticia::all() as $noticia)
        {
            ImagemNoticia::factory()->create(['noticia_id' => $noticia->id, 'image_id' => $foto_noticia->id]);
        }

    }
}
