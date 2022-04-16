<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class groups extends Model
{
    protected $table = "groups";
    protected $fillable = [
        "category_id",
        "title",
        "description",
        "subs_amount",
        "admin_id",
    ];
}
