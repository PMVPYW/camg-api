<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Capitulo extends Model
{
    use HasFactory;


    protected $table = "capitulo";
    protected $fillable = ["historia_id", "titulo"];


    public $timestamps = false;

    public function etapas(): HasMany
    {
        return $this->hasMany(Etapa::class, "capitulo_id", "id");
    }

    public function historia(): belongsTo
    {
        return $this->belongsTo(Historia::class, "historia_id", "id");
    }
}
