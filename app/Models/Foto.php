<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Foto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "fotos";
    protected $fillable = ["album_id", "image_src", "description"];
    public $timestamps = false;

    public function Album(): BelongsTo
    {
        return $this->belongsTo(Album::class, "id", "album_id");
    }

    public function ImagemNoticia(): HasMany
    {
        return $this->hasMany(ImagemNoticia::class, "image_id", "id");
    }
}
