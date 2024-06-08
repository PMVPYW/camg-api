<?php

namespace Database\Seeders;

use App\Models\Noticia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoticiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fileName = CommonSeederFunctions::storePhoto("noticia1.jpeg");
        Noticia::factory()->create([
            "titulo" => "ORGANIZAÇÃO DO RALLYE TERRAS DE AUREN ALTERA ESPECIAL A PENSAR NO BEM ESTAR ANIMAL",
            "conteudo" => "A primeira edição do Rallye Terras de Auren foi apresentada numa conferência de imprensa promovida pela Câmara Municipal e pelo Clube Automóvel da Marinha Grande. O Concelho de Ourém prepara-se para receber a adrenalina e a emoção da segunda de sete rondas do Campeonato Portugal Start Centro Ralis 2024 nos dias 19 e 20 de abril.

O encontro com a imprensa liderado pelo Presidente da Câmara Municipal de Ourém, Luís Miguel Albuquerque, também contou com a presença do Presidente do Clube Automóvel da Marinha Grande, Ferdinando Barros, do responsável de Comunicação do Clube Automóvel da Marinha Grande, Pedro Batalha, e do piloto da viatura que dá cor ao cartaz, Fábio Santos.

O Rallye Terras de Auren contempla uma prova Super Especial de 1,5 Km a realizar na Cidade de Ourém, na noite do dia 19 de abril, pelas 21h30. Já no dia 20 de abril, as especiais decorrem na região de Fátima com 15,30 Kms (10h30 e 14h00) e Espite com 13,36 Kms (11h30 e 15h00)

O Presidente da Câmara Municipal de Ourém, Luís Miguel Albuquerque, demonstrou a sua satisfação pela realização do Rallye Terras de Auren, realçando “a importância desta iniciativa para a região”. O Edil salientou ainda “o potencial do rallye para atrair visitantes e impulsionar o desenvolvimento económico e desportivo local. O seu apoio evidencia o compromisso da autarquia em promover e apoiar eventos que contribuam para o progresso e prestígio do concelho.”

Já do lado do Clube Automóvel da Marinha Grande, Ferdinando Barros, lembrou a importância do evento para o Clube Automóvel da Marinha Grande, reforçando a preocupação do clube com “a segurança e o ambiente”, fatores que considera chave para o sucesso do evento.

Marcaram também presença os Vereadores da Câmara Municipal Rui Vital, Micaela Durão e Humberto Antunes, e os Presidentes das Juntas de Freguesia parceiras institucionais.

O Rallye Terras de Auren tem como parceiros institucionais a Câmara Municipal de Ourém e a Federação Portuguesa de Karting e Automobilismo, bem como as Juntas de Freguesia de Nossa Senhora da Piedade, Nossa Senhora das Misericórdias, Atouguia, Fátima, Matas e Cercal, e Espite.

Consulte o aditamento aqui:

https://portal.fpak.pt/pub/doc/2031/274954",
            "title_img" => $fileName,
            "data" => "2024-04-21"
        ]);

        $fileName = CommonSeederFunctions::storePhoto("ourem.jpg");
        Noticia::factory()->create([
            "titulo" => "RALLYE TERRAS DE AUREN APRESENTADO",
            "conteudo" => "A primeira edição do Rallye Terras de Auren foi apresentada numa conferência de imprensa promovida pela Câmara Municipal e pelo Clube Automóvel da Marinha Grande. O Concelho de Ourém prepara-se para receber a adrenalina e a emoção da segunda de sete rondas do Campeonato Portugal Start Centro Ralis 2024 nos dias 19 e 20 de abril.

O encontro com a imprensa liderado pelo Presidente da Câmara Municipal de Ourém, Luís Miguel Albuquerque, também contou com a presença do Presidente do Clube Automóvel da Marinha Grande, Ferdinando Barros, do responsável de Comunicação do Clube Automóvel da Marinha Grande, Pedro Batalha, e do piloto da viatura que dá cor ao cartaz, Fábio Santos.

O Rallye Terras de Auren contempla uma prova Super Especial de 1,5 Km a realizar na Cidade de Ourém, na noite do dia 19 de abril, pelas 21h30. Já no dia 20 de abril, as especiais decorrem na região de Fátima com 15,30 Kms (10h30 e 14h00) e Espite com 13,36 Kms (11h30 e 15h00)

O Presidente da Câmara Municipal de Ourém, Luís Miguel Albuquerque, demonstrou a sua satisfação pela realização do Rallye Terras de Auren, realçando “a importância desta iniciativa para a região”. O Edil salientou ainda “o potencial do rallye para atrair visitantes e impulsionar o desenvolvimento económico e desportivo local. O seu apoio evidencia o compromisso da autarquia em promover e apoiar eventos que contribuam para o progresso e prestígio do concelho.”

Já do lado do Clube Automóvel da Marinha Grande, Ferdinando Barros, lembrou a importância do evento para o Clube Automóvel da Marinha Grande, reforçando a preocupação do clube com “a segurança e o ambiente”, fatores que considera chave para o sucesso do evento.

Marcaram também presença os Vereadores da Câmara Municipal Rui Vital, Micaela Durão e Humberto Antunes, e os Presidentes das Juntas de Freguesia parceiras institucionais.

O Rallye Terras de Auren tem como parceiros institucionais a Câmara Municipal de Ourém e a Federação Portuguesa de Karting e Automobilismo, bem como as Juntas de Freguesia de Nossa Senhora da Piedade, Nossa Senhora das Misericórdias, Atouguia, Fátima, Matas e Cercal, e Espite.

",
            "title_img" => $fileName,
            "data" => "2024-03-21"
        ]);
    }
}
