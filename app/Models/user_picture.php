<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_picture extends Model
{
    protected $table = "user_picture";
    protected $fillable = [
        "user_id",
        "url"
    ];
}
