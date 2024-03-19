<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagemNoticia extends Model
{
    use HasFactory;
    protected $table = "imagens_noticia";
    protected $fillable = ["noticia_id", "image_id"];
}
