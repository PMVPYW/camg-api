<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Noticia extends Model
{
    use HasFactory;

    protected $table = "noticias";
    protected $fillable = ["rally_id", "titulo", "conteudo", "title_img", "data"];


    public $timestamps = false;

    public function rally(): BelongsTo
    {
        return $this->belongsTo(Rally::class);
    }

    public function imagens(): HasMany
    {
        return $this->hasMany(ImagemNoticia::class);
    }

}
