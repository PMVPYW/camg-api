<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entidade extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "entidades";
    protected $fillable = ["nome", "photo_url", "url", "entidade_oficial"];
    public $timestamps = false;

    public function patrocinios(): HasMany
    {
        return $this->hasMany(Patrocinio::class, "entidade_id", "id");
    }
}
