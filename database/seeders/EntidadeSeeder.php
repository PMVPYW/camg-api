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
        //entidades oficiais
        $filename = CommonSeederFunctions::storePhotoEntidade('logo_fpak.png');
        Entidade::factory()->create(['nome' => 'FPAK', 'photo_url' => $filename, 'url' => 'https://www.fpak.pt/', 'entidade_oficial' => 1]);

        $filename = CommonSeederFunctions::storePhotoEntidade('infraestruturas_portugal.png');
        Entidade::factory()->create(['nome' => 'Infraestruturas de Portugal', 'photo_url' => $filename, 'url' => 'https://www.infraestruturasdeportugal.pt/', 'entidade_oficial' => 1]);
        $filename = CommonSeederFunctions::storePhotoEntidade('camara_marinha_grande.png');
        Entidade::factory()->create(['nome' => 'Camara Matinha Grande', 'photo_url' => $filename, 'url' => 'https://www.cm-mgrande.pt/', 'entidade_oficial' => 1]);

        //entidades não oficiais
        $filename = CommonSeederFunctions::storePhotoEntidade('intermarche.png');
        Entidade::factory()->create(['nome' => 'Intermarche', 'photo_url' => $filename, 'url' => 'https://www.intermarche.pt/', 'entidade_oficial' => 0]);

        $filename = CommonSeederFunctions::storePhotoEntidade('era.png');
        Entidade::factory()->create(['nome' => 'era', 'photo_url' => $filename, 'url' => 'https://www.era.pt/', 'entidade_oficial' => 0]);

        $filename = CommonSeederFunctions::storePhotoEntidade('vidrala.png');
        Entidade::factory()->create(['nome' => 'vidrala', 'photo_url' => $filename, 'url' => 'https://www.vidrala.com/', 'entidade_oficial' => 0]);
    }
}
