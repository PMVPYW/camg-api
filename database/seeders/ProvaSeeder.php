<?php

namespace Database\Seeders;

use App\Http\Controllers\ProvaController;
use App\Http\Requests\CopyProvaRequest;
use App\Http\Resources\ProvaResource;
use App\Models\Prova;
use App\Models\Rally;
use Database\Factories\ProvaFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProvaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $controller = null;

    public function run(): void
    {
        $rallies = Rally::all();
        foreach ($rallies as $rally) {
            $this->copyProvas($rally->id, $rally->external_entity_id);
        }

    }

    public function copyProvas($rally_id, $external_entity_id)
    {
        $response = Http::get('https://rest3.anube.es/rallyrest/timing/api/specials/' . $external_entity_id . '.json');
        $posts = $response->json();
        $posts = $posts['event']['data']['itineraries'][0]['specials'];
        foreach ($posts as $post) {
            Prova::factory()->create([
                'rally_id' => $rally_id,
                'external_id' => $external_entity_id,
                'local' => $post["name_extra"],
                'distancia_percurso' => $post["meters"],
                'nome' => $post["special_name"],
            ]);
        }
    }
}
