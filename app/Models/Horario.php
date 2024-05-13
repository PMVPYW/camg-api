<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'horarios';
    protected $fillable = ["rally_id", "titulo", "descricao", "inicio", "fim"];
    public $timestamps = false;

    public function rally() : BelongsTo
    {
        return $this->belongsTo(Rally::class, "id", "rally_id");
    }
}
