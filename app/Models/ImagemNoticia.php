<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImagemNoticia extends Model
{
    use HasFactory;

    protected $table = "imagens_noticia";
    protected $fillable = ["noticia_id", "image_id"];

    public $timestamps = false;


    public function noticia(): BelongsTo
    {
        return $this->belongsTo(Noticia::class);
    }

    public function foto(): belongsTo
    {
        return $this->belongsTo(Foto::class, "id", "image_id");
    }
}
