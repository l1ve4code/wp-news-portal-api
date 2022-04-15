<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subscribes extends Model
{
    protected $table = "subscribes";
    protected $fillable = [
        "user_id",
        "group_id"
    ];
}
