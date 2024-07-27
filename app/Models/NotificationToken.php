<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationToken extends Model
{
    use HasFactory;
    protected $table = "notification_tokens";
    protected $fillable = ["id_hash", "token"];


    const UPDATED_AT = null;


}
