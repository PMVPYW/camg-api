<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ZonaEspetaculo extends Model
{
    use HasFactory;
    protected $table="zona_espetaculo";
    public $timestamps=false;
    protected $fillable=["nome","prova_id","nivel_afluencia","facilidade_acesso","distancia_estacionamento","coordenadas"];

    public function prova(): belongsTo
    {
        return $this->belongsTo(Prova::class, "prova_id", "id");
    }

}
