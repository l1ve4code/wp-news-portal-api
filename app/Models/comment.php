<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    protected $table = "comment";
    protected $fillable = [
        "user_id",
        "post_id",
        "text",
        "date"
    ];
}
