<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Foto extends Model
{
    use HasFactory;

    protected $table = "fotos";
    protected $fillable = ["album_id", "image_src", "description"];
    public $timestamps = false;

    public function Album(): BelongsTo
    {
        return $this->belongsTo(Album::class, "id", "album_id");
    }
}
