<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rallies', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->string('photo_url')->nullable();
            $table->integer('external_entity_id');
            $table->timestamp("deleted_at")->nullable();
        });

        Schema::create('albuns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rally_id')->nullable()->constrained("rallies");
            $table->string("nome");
            $table->string("img")->nullable();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('fotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->constrained("albuns");
            $table->string("image_src");
            $table->longText("description")->nullable();
            $table->timestamp("deleted_at")->nullable();
        });

        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rally_id')->nullable()->constrained("rallies");
            $table->string("titulo")->unique();
            $table->longText("conteudo");
            $table->string("title_img");
            $table->date("data");
        });

        Schema::create('imagens_noticia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('noticia_id')->constrained("noticias");
            $table->foreignId('image_id')->constrained("fotos");
        });

        Schema::create('entidades', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('photo_url');
            $table->string("url");
            $table->boolean('entidade_oficial')->default(false);
            $table->unique(['nome', 'entidade_oficial']); // Garante que o nome seja único para cada entidade_oficial
            $table->timestamp("deleted_at")->nullable();
        });

        Schema::create('patrocinios', function (Blueprint $table) {
            $table->id();
            $table->integer("relevancia");
            $table->boolean('entidade_oficial')->default(false);
            $table->foreignId('entidade_id')->constrained("entidades");
            $table->foreignId('rally_id')->constrained("rallies");
        });

        //TODO --> seeders
        Schema::create('conselhos_seguranca', function (Blueprint $table) {
            $table->id();
            $table->foreignId("rally_id")->nullable()->constrained("rallies");
            $table->string("descricao");
            $table->string("img_conselho");
            $table->string("erro");
            $table->string("img_erro");

        });

        Schema::create('tipo_contacto', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->timestamp("deleted_at")->nullable();
        });

        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->enum('tipo_valor', ['Email', 'Telemovel', 'Telefone', 'Fax', 'Facebook', 'Instagram', 'Twitter', 'PaginaWeb', 'WhatsApp', 'Morada', 'Coordenadas']);
            $table->string('valor');
            $table->foreignId('tipocontacto_id')->constrained("tipo_contacto");
        });

        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rally_id')->constrained("rallies");
            $table->string('titulo');
            $table->string('descricao');
            $table->datetime('inicio');
            $table->datetime('fim');
            $table->timestamp("deleted_at")->nullable();
        });

        Schema::create('prova', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('local');
            $table->integer('distancia_percurso');
            $table->foreignId('horario_id')->nullable()->constrained("horarios");
            $table->foreignId('rally_id')->constrained("rallies");
            $table->integer('external_id');
            $table->timestamp("deleted_at")->nullable();
        });

        Schema::create('zona_espetaculo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prova_id')->constrained("prova");
            $table->string('nome');
            $table->enum('nivel_afluencia',['Fácil', 'Médio', 'Difícil']);
            $table->enum('facilidade_acesso',['Fácil', 'Médio', 'Difícil']);
            $table->integer('distancia_estacionamento');
            $table->string('coordenadas');
            $table->enum('nivel_ocupacao',['Livre', 'Intermédio', 'Completo']);
            $table->unique(['nome', 'prova_id']); // Garante que o nome seja único para cada prova_id
            $table->unique(['coordenadas', 'prova_id']); // Garante que o coordenadas seja único para cada prova_id
        });

        Schema::create('historia', function (Blueprint $table) {
            $table->id();
            $table->string("titulo");
            $table->string("subtitulo");
            $table->string("conteudo");
            $table->string('photo_url');
        });

        Schema::create('departamento', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->timestamp("deleted_at")->nullable();
        });

        Schema::create('orgaos_sociais', function (Blueprint $table) {
            $table->id();
            $table->string("nome")->unique();
            $table->enum('cargo',['presidente', 'secretario', 'vice-presidente', 'vogal']);
            $table->integer("relevancia");
            $table->string('photo_url');
            $table->foreignId('departamento_id')->constrained("departamento");
        });


        Schema::create('declaracoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rally_id')->constrained("rallies");
            $table->string('conteudo');
            $table->string('nome');
            $table->string('cargo');
            $table->string('photo_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historia');
        Schema::dropIfExists('departamento');
        Schema::dropIfExists('orgaos_sociais');
        Schema::dropIfExists('zona_espetaculo');
        Schema::dropIfExists('horarios');
        Schema::dropIfExists('prova');
        Schema::dropIfExists('conselhos_segurança');
        Schema::dropIfExists('patrocionios');
        Schema::dropIfExists('entidades');
        Schema::dropIfExists('imagens_noticia');
        Schema::dropIfExists('noticias');
        Schema::dropIfExists('fotos');
        Schema::dropIfExists('albuns');
        Schema::dropIfExists('rallies');
        Schema::dropIfExists('contactos');
        Schema::dropIfExists('tipo_contacto');
        Schema::dropIfExists('declaracoes');
    }
};
