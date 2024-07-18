<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Declaracao extends Model
{
    use HasFactory;
    protected $table = 'declaracoes';
    protected $fillable = ['rally_id', 'conteudo', 'nome', 'cargo', 'photo_url','entidade_equipa'];
    public $timestamps = false;

    public function rally() : BelongsTo
    {
        return $this->belongsTo(Rally::class, 'rally_id', 'id');
    }
}

