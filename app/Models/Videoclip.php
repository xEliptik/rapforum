<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videoclip extends Model
{
    use HasFactory;

    protected $table = 'videoclip';
    protected $fillable = [
        'song',
        'singer',
        'description',
        'views',
        'award',
        'image',
    ];
}
