<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoContacto extends Model
{
    use HasFactory;
    protected $table = "tipo_contacto";
    protected $fillable = ["nome"];

    public $timestamps = false;

    public function contactos(): HasMany
    {
        return $this->hasMany(Contacto::class, "tipocontacto_id", "id");
    }
}
