<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $table = 'ratings';
    protected $fillable = [
        'user_id',
        'section_id',
        'stars_rated',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }
}
