<?php

namespace Database\Seeders;

use App\Models\Contacto;
use App\Models\TipoContacto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacto_emergencia = TipoContacto::query()->where('nome', 'emergência')->first();
        Contacto::factory()->create(['tipocontacto_id' => $contacto_emergencia->id, 'tipo_valor' => 'Telemovel', 'valor' => '112', 'nome' => '112']);

        $contacto_camg = TipoContacto::query()->where('nome', 'CAMG')->first();
        Contacto::factory()->create(['tipocontacto_id' => $contacto_camg->id, 'tipo_valor' => 'Telemovel', 'valor' => '+351 926 352 757', 'nome' => 'Telemovel']);
        Contacto::factory()->create(['tipocontacto_id' => $contacto_camg->id, 'tipo_valor' => 'Morada', 'valor' => 'RUA DA LAGOA N31, 2430-185 MARINHA GRANDE', 'nome' => 'morada']);
        Contacto::factory()->create(['tipocontacto_id' => $contacto_camg->id, 'tipo_valor' => 'Email', 'valor' => 'geral@camg.pt', 'nome' => 'email geral']);
        Contacto::factory()->create(['tipocontacto_id' => $contacto_camg->id, 'tipo_valor' => 'Telefone', 'valor' => '+351 244 502 212', 'nome' => 'telefone fixo']);

    }
}
