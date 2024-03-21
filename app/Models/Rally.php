<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rally extends Model
{
    use HasFactory;

    protected $table = "rallies";
    public $timestamps = false;
    protected $fillable = ["nome", "data_inicio", "data_fim", "external_entity_id"];

    public function noticias(): HasMany
    {
        return $this->hasMany(Noticia::class);
    }
}
