<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Historia extends Model
{
    use HasFactory;

    protected $table = "historia";
    protected $fillable = ["titulo", "conteudo", "photo_url", "subtitulo"];


    public $timestamps = false;

    public function capitulos(): HasMany
    {
        return $this->hasMany(Capitulo::class, "historia_id", "id");
    }
}
