<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;
    protected $table = "noticias";
    protected $fillable = ["rally_id", "titulo", "conteudo", "title_img", "data"];
}
