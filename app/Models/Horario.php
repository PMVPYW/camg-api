<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Horario extends Model
{
    use HasFactory;
    protected $table = "horario";
    protected $fillable = ["data_inicio"];

    public $timestamps = false;

    public function prova(): HasOne
    {
        return $this->hasOne(Prova::class, "horario_id", "id");
    }
}
