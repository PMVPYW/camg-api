<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rally extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "rallies";
    public $timestamps = false;
    protected $fillable = ["nome", "data_inicio", "data_fim", "external_entity_id", "photo_url"];

    public function declaracoes()
    {
        return $this->hasMany(Declaracao::class, 'rally_id', 'id');
    }

    public function conselhos_seguranca(): HasMany
    {
        return $this->hasMany(ConselhoSeguranca::class, "rally_id", "id");
    }

    public function noticias(): HasMany
    {
        return $this->hasMany(Noticia::class, "rally_id", "id");
    }

    public function Albuns(): HasMany
    {
        return $this->hasMany(Album::class, "rally_id", "id");
    }

    public function patrocinios(): HasMany
    {
        return $this->hasMany(Patrocinio::class, "rally_id", "id");
    }
}
