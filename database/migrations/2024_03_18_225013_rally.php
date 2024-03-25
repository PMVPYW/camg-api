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
            $table->string("titulo");
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
            $table->timestamp("deleted_at")->nullable();

        });

        Schema::create('patrocinios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entidade_id')->constrained("entidades");
            $table->foreignId('rally_id')->constrained("rallies");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patrocionios');
        Schema::dropIfExists('entidades');
        Schema::dropIfExists('imagens_noticia');
        Schema::dropIfExists('noticias');
        Schema::dropIfExists('fotos');
        Schema::dropIfExists('albuns');
        Schema::dropIfExists('rallies');
    }
};
