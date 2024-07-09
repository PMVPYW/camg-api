<?php

namespace Database\Seeders;

use App\Models\Rally;
use App\Models\ZonaEspetaculo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZonaEspetaculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Zonas de Espetáculo Rally Vidreiro
        $rally_vidreiro = Rally::query()->where('external_entity_id', 111)->first();
        ZonaEspetaculo::factory()->create([
            'prova_id' => $rally_vidreiro->provas[0] ,
            'nome' => "ze_1",
            'nivel_afluencia' => 'Médio',
            'facilidade_acesso' => 'Difícil',
            'distancia_estacionamento' => 12,
            'nivel_ocupacao' => 'Completo',
            'coordenadas' => '[-8.400920882603259,39.69581627066367],[-8.358695536592506,39.681707271748365],[-8.385364176177461,39.643641356575245],[-8.447591001876873,39.65647490666902],[-8.400920882603259,39.69581627066367]',
            'info'=> 'Tem casa de banho',
        ]);
        ZonaEspetaculo::factory()->create([
            'prova_id' => $rally_vidreiro->provas[1] ,
            'nome' => "ze_2",
            'nivel_afluencia' => 'Alto',
            'facilidade_acesso' => 'Fácil',
            'distancia_estacionamento' => 23,
            'nivel_ocupacao' => 'Intermédio',
            'coordenadas' => '[-8.805166203504967,39.64754996149466],[-8.76014530821925,39.64905713498072],[-8.78011109656336,39.62614455248567],[-8.815736326745963,39.61830429500591],[-8.843923322056156,39.627652192475495],[-8.831395768585338,39.64272678555844],[-8.805166203504967,39.64754996149466]',
            'info'=> 'Tem comes e bebes',
        ]);
        ZonaEspetaculo::factory()->create([
            'prova_id' => $rally_vidreiro->provas[2] ,
            'nome' => "ze_3",
            'nivel_afluencia' => 'Baixo',
            'facilidade_acesso' => 'Médio',
            'distancia_estacionamento' => 34,
            'nivel_ocupacao' => 'Livre',
            'coordenadas' => '[-8.889441033546149,39.58515702744964],[-8.846180542533347,39.5687676696854],[-8.860111887096764,39.547286094111286],[-8.926835695269915,39.54841686920983],[-8.931235067237338,39.5682024503013],[-8.910704664722772,39.59476278026176],[-8.889441033546149,39.611710859783784],[-8.889441033546149,39.58515702744964]',
            'info'=> 'Não recomendado para crianças ',
        ]);

        //Zonas de Espetáculo Rally Terras de Auren
        $rally_auren = Rally::query()->where('external_entity_id', 141)->first();
        ZonaEspetaculo::factory()->create([
            'prova_id' => $rally_auren->provas[0] ,
            'nome' => "ze_4",
            'nivel_afluencia' => 'Médio',
            'facilidade_acesso' => 'Difícil',
            'distancia_estacionamento' => 12,
            'nivel_ocupacao' => 'Completo',
            'coordenadas' => '[-8.723760357741014,39.53267898048193],[-8.694122010265318,39.5252245842579],[-8.697987881675118,39.48296789040711],[-8.73922384338016,39.474016117597245],[-8.723760357741014,39.53267898048193]',
            'info'=> 'Tem casa de banho mista',
        ]);
        ZonaEspetaculo::factory()->create([
            'prova_id' => $rally_auren->provas[1] ,
            'nome' => "ze_5",
            'nivel_afluencia' => 'Alto',
            'facilidade_acesso' => 'Fácil',
            'distancia_estacionamento' => 23,
            'nivel_ocupacao' => 'Intermédio',
            'coordenadas' => '[-9.405532308067762,39.36803340082656],[-9.393645590183638,39.373045661299955],[-9.382839483016255,39.37137494778568],[-9.374194597282354,39.36636256738302],[-9.363388490114971,39.35800780054251],[-9.380678261582773,39.35383004237019],[-9.40337108663428,39.35383004237019],[-9.41093536165144,39.36134982720145],[-9.405532308067762,39.36803340082656]',
            'info'=> 'Tem comes e bebes, relote de Kebab',
        ]);
    }
}
