<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Prova extends Model
{
    use HasFactory;
    protected $table = "prova";
    protected $fillable = ["rally_id","external_id","local","distancia_percurso","horario_id","nome","kml_src"];

    public $timestamps = false;

    public function rally(): belongsTo
    {
        return $this->belongsTo(Rally::class, "id", "rally_id");
    }

    public function horario() : HasOne
    {
        return $this->HasOne(Horario::class, "id", "horario_id");
    }

    public function zonas_espetaculo(): HasMany
    {
        return $this->hasMany(ZonaEspetaculo::class, "prova_id", "id");
    }

}
