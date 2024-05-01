<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Prova extends Model
{
    use HasFactory;
    protected $table = "horario";
    protected $fillable = ["horario_id","rally_id","external_id","local","distancia_percurso"];

    public $timestamps = false;

    public function horario(): HasOne
    {
        return $this->hasOne(Horario::class, "id", "horario_id");
    }

    public function rally(): belongsTo
    {
        return $this->belongsTo(Rally::class, "id", "rally_id");
    }

}
