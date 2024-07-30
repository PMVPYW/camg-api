<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\ConselhoSeguranca;
use App\Models\Rally;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConselhoSegurancaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $certo1 = CommonSeederFunctions::storePhoto("security1.png");
        $errado1 = CommonSeederFunctions::storePhoto("security_error1.png");

        ConselhoSeguranca::factory()->create([
            "descricao" => "Não se distraia, não brinque com a sua segurança",
            "erro" => "Brincar com a segurança e andar distraido",
            "img_conselho" => $certo1,
            "img_erro" => $errado1
        ]);

        $certo2 = CommonSeederFunctions::storePhoto("security2.png");
        $errado2 = CommonSeederFunctions::storePhoto("security_error2.png");

        ConselhoSeguranca::factory()->create([
            "descricao" => "Não fique ou ande no meio da estrada",
            "erro" => "Ficar ou andar no meio da estrada",
            "img_conselho" => $certo2,
            "img_erro" => $errado2
        ]);

        $certo3 = CommonSeederFunctions::storePhoto("security3.png");
        $errado3 = CommonSeederFunctions::storePhoto("security_error3.png");

        ConselhoSeguranca::factory()->create([
            "descricao" => "Não fique em áreas perigosas",
            "erro" => "Ficar em áreas perigosas",
            "img_conselho" => $certo3,
            "img_erro" => $errado3
        ]);

        $certo4 = CommonSeederFunctions::storePhoto("security4.png");
        $errado4 = CommonSeederFunctions::storePhoto("security_error4.png");

        ConselhoSeguranca::factory()->create([
            "descricao" => "Não fique nas valetas",
            "erro" => "Ficar nas valetas",
            "img_conselho" => $certo4,
            "img_erro" => $errado4
        ]);

        $certo5 = CommonSeederFunctions::storePhoto("security5.png");
        $errado5 = CommonSeederFunctions::storePhoto("security_error5.png");

        ConselhoSeguranca::factory()->create([
            "descricao" => "Não leve animais consigo",
            "erro" => "Levar animais consigo",
            "img_conselho" => $certo5,
            "img_erro" => $errado5
        ]);

        $certo6 = CommonSeederFunctions::storePhoto("security6.png");
        $errado6 = CommonSeederFunctions::storePhoto("security_error6.png");

        ConselhoSeguranca::factory()->create([
            "descricao" => "Mantenha as crianças sob vigilância constante",
            "erro" => "Não olhar pelas crianças",
            "img_conselho" => $certo6,
            "img_erro" => $errado6
        ]);
    }
}
