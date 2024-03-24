<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entidade extends Model
{
    use HasFactory;
    protected $table = "entidades";
    protected $fillable = ["nome", "photo_url", "url"];
    public $timestamps = false;

    public function patrocinios(): HasMany
    {
        return $this->hasMany(Patrocinio::class, "entidade_id", "id");
    }
}
