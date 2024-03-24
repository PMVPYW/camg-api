<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Patrocinio extends Model
{
    use HasFactory;

    protected $table = "patrocinios";
    protected $fillable = ["entidade_id", "rally_id"];
    public function entidade(): BelongsTo
    {
        return $this->belongsTo(Entidade::class, "id", "entidade_id");
    }

    public function rallys(): BelongsToMany
    {
        return $this->belongsToMany(Rally::class);
    }

}
