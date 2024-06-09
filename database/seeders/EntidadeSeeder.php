<?php

namespace Database\Seeders;

use App\Models\Entidade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filename = CommonSeederFunctions::storePhotoEntidade('logo_fpak.png');
        Entidade::factory()->create(['nome' => 'FPAK', 'photo_url' => $filename, 'url' => 'https://www.fpak.pt/', 'entidade_oficial' => 1]);
    }
}
