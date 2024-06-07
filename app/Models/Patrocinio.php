<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patrocinio extends Model
{
    use HasFactory;
    protected $table = "patrocinios";
    protected $fillable = ["entidade_id", "rally_id", "entidade_oficial", "relevancia"];
    public $timestamps = false;

    public function entidade(): BelongsTo
    {
        return $this->belongsTo(Entidade::class, "entidade_id", "id");
    }

    public function rallys(): HasMany
    {
        return $this->hasMany(Rally::class, "id", "rally_id");
    }

}
