<?php

namespace Database\Seeders;

use App\Models\Declaracao;
use App\Models\Rally;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeclaracaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rally_vidreiro = Rally::query()->where('external_entity_id', 111)->first();
        $fileName = CommonSeederFunctions::storePhotoDeclaracoes("avatar.jpg");
        Declaracao::factory()->create([
            'nome' => 'Aurelio Ferreira',
            'cargo' => 'Presidente',
            'conteudo' => 'É com grande entusiasmo que recebemos o Rallye Vidreiro Centro de Portugal!
                            Celebramos uma prova histórica, que tanto orgulho traz à Marinha Grande e à região.
                            Em 2023, o Rallye Vidreiro expande os seus horizontes e conquista novos desafios ao percorrer não apenas a Marinha Grande, onde já se consolidou como um espetáculo emocionante e de reconhecido mérito, mas também os concelhos de Alcobaça e Pombal.
                            Através deste evento, unimos estes três territórios em torno de uma paixão compartilhada, celebrando a destreza e a determinação dos pilotos, em provas que pretendemos sejam realizadas em total segurança dos praticantes e dos amantes da modalidade.
                            Estamos perante um evento com grande impacto na animação desportiva e na promoção turística da região, cuja excelência da organização é enaltecida.
                            Afirmo, com regozijo, que o Município da Marinha Grande tem sido e continuará a ser uma entidade parceira desta atividade. Expresso a minha profunda gratidão ao Clube Automóvel, Municípios envolvidos, parceiros, equipas, patrocinadores, voluntários e a todos os que tornam possível este espetáculo. É o esforço de todos que permite que o Rallye Vidreiro Centro de Portugal continue a crescer e a emocionar multidões a cada ano. Obrigado e divirtam-se!',
            'entidade_equipa' => 'Câmara Municipal da Marinha Grande',
            'rally_id' => $rally_vidreiro,
            'photo_url' => $fileName
        ]);

        Declaracao::factory()->create([
            'nome' => 'Pedro Pimpão',
            'cargo' => 'Presidente',
            'conteudo' => 'É com enorme agrado que o Município de Pombal acolhe o Rallye Vidreiro Centro Portugal, uma prova de renome nacional e internacional, integrada no Campeonato de Portugal de Ralis e que agora adquire um cariz intermunicipal, demonstrando que juntos somos muito mais fortes.
                        Reconhecemos a importância que estas iniciativas assumem na promoção do nosso território, contribuindo para o incremento da atividade económica e turística da região e mitigando o impacto da sazonalidade do turismo.
                        Acreditamos que o Rally Vidreiro Centro Portugal não se assume apenas como uma competição automobilística, mas também a celebração da paixão pelo desporto e um tributo à beleza dos vários trilhos e paisagens da nossa região. Esta é mais uma boa oportunidade para mostrarmos o que Pombal tem para oferecer e dar a conhecer todas as nossas potencialidades. Que a presente edição permita criar memórias inesquecíveis do território de Pombal para todos os pilotos, navegadores, equipas e apaixonados do desporto automóvel.
                        Desejo as maiores felicidades para toda a competição e deixo o meu ensejo para que cada curva e cada etapa deste evento traga a adrenalina e a alegria suficientes para aqui quererem regressar. Um forte abraço amigo!',
            'entidade_equipa' => 'Câmara Municipal de Pombal',
            'rally_id' => $rally_vidreiro,
            'photo_url' => $fileName
        ]);

        Declaracao::factory()->create([
            'nome' => 'Hermínio Rodrigues',
            'cargo' => 'Presidente',
            'conteudo' => 'É com muito orgulho que Alcobaça se associa a esta edição do Rallye Vidreiro Centro de Portugal! Este ano, a competição vai unir os concelhos de Alcobaça, Marinha Grande e Pombal. Esta prova mítica do desporto motorizado tem muita tradição e é de reconhecida notoriedade.
                        O Rallye Vidreiro, organizado pelo Clube Automóvel da Marinha Grande, é uma das provas mais famosas do Campeonato Portugal de Ralis e importantíssimo para a economia, turismo e projeção da nossa região.
                        Convidamos as nossas gentes para uma tarde de emoções fortes!',
            'entidade_equipa' => 'Câmara Municipal de Alcobaça',
            'rally_id' => $rally_vidreiro,
            'photo_url' => $fileName
        ]);

        $fileName_1 = CommonSeederFunctions::storePhotoDeclaracoes("MiguelCorreia.jpg");
        Declaracao::factory()->create([
            'nome' => 'Miguel Correia',
            'cargo' => 'Piloto',
            'conteudo' => 'Chegar aqui ao Rallye Vidreiro com possibilidades reais de chegar ao título é fantástico porque, se bem se lembram, fui o único a assumir publicamente que o grande objetivo para este ano era ser Campeão Nacional. Demos o nosso melhor durante todo o campeonato, apesar de alguns altos e baixos. Apesar de termos adversários muito mais experientes somos nós que estamos na liderança e, por isso, mais bem posicionados para chegar ao objetivo.',
            'rally_id' => $rally_vidreiro,
            'photo_url' => $fileName_1,
            'pontos' => 116
        ]);

        $fileName_2 = CommonSeederFunctions::storePhotoDeclaracoes("JosePedroFontes.jpg");
        Declaracao::factory()->create([
            'nome' => 'José Pedro Fontes',
            'cargo' => 'Piloto',
            'conteudo' => 'Naturalmente que o nosso único objetivo é ganhar o campeonato. Penso que temos uma boa oportunidade, estamos com um bom ritmo e o Citroen C3 Rally2 preparado pela Sports & You está bastante bem preparado para o desafio. Este é um rali que eu que eu gosto particularmente, e numa zona onde já ganhei várias vezes, portanto não há outra motivação que não seja ganhar e chegar ao título.',
            'rally_id' => $rally_vidreiro,
            'photo_url' => $fileName_2
        ]);

        $fileName_3 = CommonSeederFunctions::storePhotoDeclaracoes("RicardoTeodosio.jpg");
        Declaracao::factory()->create([
            'nome' => 'Ricardo Teodósio',
            'cargo' => 'Piloto',
            'conteudo' => 'Este final de campeonato é sinónimo da competitividade que existiu ao longo de toda a temporada. Tivemos uma temporada positiva e o Hyundai i20 N Rally2 foi sempre uma arma capaz de lutar pelas vitórias. O momento é de concentração e de mostrar que somos capazes de vencer estes adversários que, acima de tudo são nossos amigos. Pela minha família, amigos, fãs prometo lutar com todas as forças pelo tão ambicionado título de Campeão Nacional.',
            'rally_id' => $rally_vidreiro,
            'photo_url' => $fileName_3
        ]);

        $fileName_4 = CommonSeederFunctions::storePhotoDeclaracoes("ArmindoAraujo.jpg");
        Declaracao::factory()->create([
            'nome' => 'Armindo Araújo',
            'cargo' => 'Piloto',
            'conteudo' => 'Para mim é uma enorme alegria e satisfação poder chegar ao Rallye Vidreiro ainda na luta pelo campeonato depois de uma temporada onde atravessei grandes dificuldades devido ao acidente. Estar aqui nesta situação é já uma grande vitória. Relativamente ao rali em si vai ser um grande desafio com quatro pilotos na luta para serem campeões. Desejo que ganhe o melhor, sem jogos de bastidores. Nós vamos dar o nosso melhor para chegar à vitória.',
            'rally_id' => $rally_vidreiro,
            'photo_url' => $fileName_4
        ]);
    }
}
