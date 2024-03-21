<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    use HasFactory;
    protected $table = "albuns";
    protected $fillable = ["rally_id", "nome"];

    public $timestamps = false;

    public function rally(): belongsTo
    {
        return $this->belongsTo(Rally::class, "id", "rally_id");
    }

    public function Photos(): HasMany
    {
        return $this->hasMany(Foto::class, "album_id", "id");
    }
}
