<?php

namespace Database\Seeders;

use App\Models\Horario;
use App\Models\Prova;
use App\Models\Rally;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rally_vidreiro = Rally::query()->where('external_entity_id', 111)->first();
        $provas = Prova::all();
        Horario::factory()->create(['rally_id' => $rally_vidreiro->id, 'titulo' => 'verificações ténicas', 'descricao' => 'verificações ténicas dos carros na prova',
            'inicio' => '2024-10-10 08:00:00', 'fim' => '2024-10-10 10:00:00']);

        $inicio = 10;
        $dia = 1;

        foreach ($provas as $prova) {
            $horario = Horario::factory()->create(['rally_id' => $rally_vidreiro->id, 'titulo' => $prova->local, 'descricao' => 'Prova',
                'inicio' => '2024-10-' . (9 + $dia) . ' ' . $inicio . ':00:00',
                'fim' => '2024-10-' . (9 + $dia) . ' ' . ($inicio + 2) . ':00:00']);
            $prova->horario_id = $horario->id;
            $prova->save();
            $inicio += 3;
            if ($inicio + 2 > 23) {
                $dia+=1;
                $inicio = 01;
            }
        }
    }
}
