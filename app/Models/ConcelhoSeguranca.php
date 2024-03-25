<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConcelhoSeguranca extends Model
{
    use HasFactory;

    protected $table = 'concelhos_seguranca';
    protected $fillable = ["rally_id", "descricao", "img_concelho", "erro", "img_erro"];

    public $timestamps = false;

    public function rally(): BelongsTo
    {
        return $this->belongsTo(Rally::class, "id", "rally_id");
    }

}
