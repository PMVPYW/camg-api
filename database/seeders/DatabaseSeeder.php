<?php

namespace Database\Seeders;

use App\Models\Noticia;
use App\Models\Patrocinio;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public static $seedType = "deploy";
    public function run(): void
    {

        Storage::deleteDirectory("public/fotos");
        Storage::makeDirectory("public/fotos");
        Storage::deleteDirectory("public/entidades");
        Storage::makeDirectory("public/entidades");

        User::factory()->create([
            'nome' => 'Test User',
            'email' => 'test@example.com',
            "password" => "123",
            "authorized" => true,
            "blocked" => 0
        ]);

        DatabaseSeeder::$seedType = $this->command->choice('What is the size of seed data (choose "deploy" for publishing)?', ['deploy', 'test'], 0);
        if (DatabaseSeeder::$seedType == "deploy") {
            return;
        }

        User::factory(10)->create();
        $this->call(RallySeeder::class);
        $this->call(ProvaSeeder::class);
        $this->call(AlbumSeeder::class);
        $this->call(FotoSeeder::class);
        $this->call(NoticiaSeeder::class);
        $this->call(ImagemNoticiaSeeder::class);
        $this->call(EntidadeSeeder::class);
        $this->call(PatrocinioSeeder::class);
        $this->call(TipoContactoSeeder::class);
        $this->call(ContactoSeeder::class);
        $this->call(HorarioSeeder::class);
        $this->call(ZonaEspetaculoSeeder::class);
        $this->call(HistoriaSeeder::class);
        $this->call(CapituloSeeder::class);
        $this->call(EtapaSeeder::class);
        $this->call(DeclaracaoSeeder::class);

    }
}
