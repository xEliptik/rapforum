<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;
    protected $table = 'sections';
    protected $fillable = [
        'cate_id',
        'name',
        'small_description',
        'description',
        'image',
        'status',
        'trending',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'position',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'cate_id', 'id');
    }
}


