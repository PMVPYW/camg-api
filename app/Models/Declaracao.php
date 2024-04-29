<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Declaracao extends Model
{
    use HasFactory;
    protected $table = 'declaracoes';
    protected $fillable = ['rally_id', 'conteudo', 'nome', 'cargo'];
    public $timestamps = false;

    public function rally()
    {
        return $this->belongsTo(Rally::class, 'id', 'rally_id');
    }
}

