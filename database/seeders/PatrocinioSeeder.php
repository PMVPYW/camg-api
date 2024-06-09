<?php

namespace Database\Seeders;

use App\Models\Entidade;
use App\Models\Patrocinio;
use App\Models\Rally;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatrocinioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patrocionios = Entidade::all();
        $rally_vidreiro = Rally::query()->where('external_entity_id', 111)->first();
        foreach ($patrocionios as $patrocinio) {
            Patrocinio::factory()->create(['rally_id' => $rally_vidreiro->id, 'entidade_id' => $patrocinio->id, 'relevancia' => 3, 'entidade_oficial' => $patrocinio->entidade_oficial]);
        }
    }
}
