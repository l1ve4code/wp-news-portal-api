<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    protected $table = "post";
    protected $fillable = [
        "category_id",
        "post_id",
        "title",
        "description",
        "short_desc",
        "like_amount",
        "see_amount",
        "comm_amount",
    ];
}
