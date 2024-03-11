<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Starred_gifs extends Model
{
    use HasFactory;

    protected $fillable = [
        'gif_id',
        'user_id',
        'alias'
    ];

}
