<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contacto extends Model
{
    use HasFactory;
    protected $table = "contactos";
    protected $fillable = ["nome","tipo_valor", "valor", "tipocontacto_id"];

    public $timestamps = false;

    public function tipo_contacto(): belongsTo
    {
        return $this->belongsTo(TipoContacto::class);
    }
}
