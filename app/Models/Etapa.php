<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Etapa extends Model
{
    use HasFactory;

    protected $table = "etapa";
    protected $fillable = ["nome", "ano_inicio", "ano_fim", "capitulo_id"];


    public $timestamps = false;

    public function capitulo(): belongsTo
    {
        return $this->belongsTo(Capitulo::class, "capitulo_id", "id");
    }
}
