<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rally extends Model
{
    use HasFactory;

    protected $table = "rallies";
    public $timestamps = false;
    protected $fillable = ["nome", "data_inicio", "data_fim", "external_entity_id"];
}
