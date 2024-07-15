<?php

namespace Database\Seeders;

use App\Models\Etapa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtapaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Associar ao Capítulo Rally Vidreiro
            Etapa::factory()->create([
                "capitulo_id" => 1,
                "nome" => "Rallye Vidreiro - Campeonato Regional de Promoção",
                "ano_inicio" => "1971",
                "ano_fim" => "1977",
            ]);
            Etapa::factory()->create([
                "capitulo_id" => 1,
                "nome" => "Rampa de Porto de Mós - Campeonato Nacional de Velocidade",
                "ano_inicio" => "1977",
                "ano_fim" => "1981",
            ]);
            Etapa::factory()->create([
                "capitulo_id" => 1,
                "nome" => "Troféu Koni (Galardão)",
                "ano_inicio" => "1980",
            ]);
            Etapa::factory()->create([
                "capitulo_id" => 1,
                "nome" => "Rallye Vidreiro - Campeonato Nacional de Promoção e Clássicos",
                "ano_inicio" => "1999",
                "ano_fim" => "2000",
            ]);
            Etapa::factory()->create([
                "capitulo_id" => 1,
                "nome" => "Rallye Pinhais do Centro - Campeonato Nacional de Promoção e Clássicos",
                "ano_inicio" => "2001",
            ]);
            Etapa::factory()->create([
                "capitulo_id" => 1,
                "nome" => "Rallye Vidreiro Centro de Portugal - Campeonato Nacional de Ralis",
                "ano_inicio" => "2002",
                "ano_fim" => "2017",
            ]);

        //Associação ao capítulo Provas dos Troféus Regionais
            Etapa::factory()->create([
                "capitulo_id" => 2,
                "nome" => "Rallye da Usseira - Troféu Regional de Rallyes do Oeste",
                "ano_inicio" => "1999",
            ]);
            Etapa::factory()->create([
                "capitulo_id" => 2,
                "nome" => "Rally de Albergaria dos Doze- Troféu Regional de Rallyes Norte, Centro e Oeste",
                "ano_inicio" => "1999",
            ]);
            Etapa::factory()->create([
                "capitulo_id" => 2,
                "nome" => "Rallye Albergaria dos Doze - Troféu Regional do Oeste",
                "ano_inicio" => "2000",
            ]);
            Etapa::factory()->create([
                "capitulo_id" => 2,
                "nome" => "Rallye Pinhais do Zêzere - Troféu de Rallyes do Centro",
                "ano_inicio" => "2000",
            ]);

        //Associação ao capítulo Rallye ROta do Sol
            Etapa::factory()->create([
                "capitulo_id" => 3,
                "nome" => "Rallye Rota do Sol - Campeonato Nacional de Rallyes",
                "ano_inicio" => "1978",
                "ano_fim" => "1980",
            ]);
            Etapa::factory()->create([
                "capitulo_id" => 3,
                "nome" => "Rallye Rota do Sol - Passa a Internacional até 1990",
                "ano_inicio" => "1981",
            ]);
            Etapa::factory()->create([
                "capitulo_id" => 3,
                "nome" => "Melhor Organização de Rallye Troféu Yoplai",
                "ano_inicio" => "1979",
            ]);
            Etapa::factory()->create([
                "capitulo_id" => 3,
                "nome" => "Exito de Rallyes Correio da Manhã",
                "ano_inicio" => "1985",
            ]);
            Etapa::factory()->create([
                "capitulo_id" => 3,
                "nome" => "Campeonato da Europa e Nacional de Rallyes",
                "ano_inicio" => "1991",
                "ano_fim" => "1999",
            ]);
            Etapa::factory()->create([
                "capitulo_id" => 3,
                "nome" => "Rallye Rota do Sol /para Rallye Rota do Vidro - Centro de Portugal - Campeonato Nacional e da Europa de Rallyes",
                "ano_inicio" => "2000",
                "ano_fim" => "2001",
            ]);

    }
}
