<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;
    protected $table = 'forum';
    protected $fillable = [
        'cate_id',
        'user_id',
        'title',
        'description',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cate_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function incrementLikes()
    {
        $this->likes++;
        $this->save();
    }

    public function decrementLikes()
    {
        $this->likes--;
        $this->save();
    }

    public function incrementDislikes()
    {
        $this->dislikes++;
        $this->save();
    }

    public function decrementDislikes()
    {
        $this->dislikes--;
        $this->save();
    }

    public function likes()
    {
        return $this->hasMany(ForumVotes::class)->where('type', 'like');
    }

    public function dislikes()
    {
        return $this->hasMany(ForumVotes::class)->where('type', 'dislike');
    }

}