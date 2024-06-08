<?php

namespace Database\Seeders;

use App\Models\Album;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fileName = CommonSeederFunctions::storePhoto("vidreiro.jpeg");
        Album::factory()->create([
            'nome' => "Rally Vidreiro",
            "img" => $fileName,
        ]);
    }
}
