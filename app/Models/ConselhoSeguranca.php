<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConselhoSeguranca extends Model
{
    use HasFactory;

    protected $table = 'conselhos_seguranca';
    protected $fillable = ["descricao", "img_conselho", "erro", "img_erro"];

    public $timestamps = false;

}
