<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConselhoSeguranca extends Model
{
    use HasFactory;

    protected $table = 'conselhos_seguranca';
    protected $fillable = ["rally_id", "descricao", "img_conselho", "erro", "img_erro"];

    public $timestamps = false;

    public function rally(): BelongsTo
    {
        return $this->belongsTo(Rally::class, "id", "rally_id");
    }

}
