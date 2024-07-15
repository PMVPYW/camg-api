<?php

namespace Database\Seeders;

use App\Models\Historia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fileName = CommonSeederFunctions::storePhoto("history.jpg");
        Historia::factory()->create([
            "titulo" => "A nossa história",
            "subtitulo" => "SOBRE O CLUBE AUTOMÓVEL DA MARINHA GRANDE",
            "conteudo" => "Com 50 anos de história, comemorados em 2020, o Clube Automóvel da Marinha Grande (CAMG) é um importante dinamizador do desporto automóvel na região centro do país, que tenta sempre que possível organizar atividades que levem mais longe o nome da Marinha Grande, como tem sido o caso do Rallye Vidreiro, que tanto dignifica o concelho e que tem enorme exposição mediática nacional e internacional.Sendo o único associado da Federação Portuguesa de Automobilismo e Karting que, desde sempre, e ininterruptamente, contou com provas no Campeonato de Portugal de Ralis, o Clube Automóvel da Marinha Grande preza pelo rigor e transparência a sua actuação.",
            "photo_url" => "$fileName"
        ]);

        Historia::factory()->create([
            "titulo" => "Atividades Desportivas",
            "subtitulo" => "FUNDAÇÃO EM 21 DE JANEIRO DE 1970",
        ]);
    }
}
