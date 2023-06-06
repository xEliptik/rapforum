<?php

namespace App\Models;

use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $fillable = [
        'user_id',
        'section_id',
        'user_review',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }
}