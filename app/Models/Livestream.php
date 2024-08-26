<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Livestream extends Model
{
    use HasFactory;

    protected $table = "livestream";
    protected $fillable = ["rally_id", "link", "visivel", "enable_timestamp", "nome"];

    const UPDATED_AT = null;
    const CREATED_AT = null;


    public function rally(): BelongsTo
    {
        return $this->belongsTo(Rally::class, "rally_id", "id");
    }
}
