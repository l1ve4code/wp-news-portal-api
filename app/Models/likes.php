<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class likes extends Model
{
    protected $table = "likes";
    protected $fillable = [
        "user_id",
        "post_id",
    ];
}
