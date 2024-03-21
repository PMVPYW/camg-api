<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Album extends Model
{
    use HasFactory;
    protected $table = "albuns";
    protected $fillable = ["rally_id", "nome"];

    public $timestamps = false;

    public function rally(): HasOne
    {
        return $this->hasOne(Rally::class, "id", "rally_id");
    }

}
