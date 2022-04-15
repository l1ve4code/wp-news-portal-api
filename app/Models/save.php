<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class save extends Model
{
    protected $table = "save";
    protected $fillable = [
        "post_id",
        "user_id"
    ];
}
