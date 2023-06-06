<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumComments extends Model
{
    use HasFactory;
    protected $table = 'forum_comments';

    protected $fillable = [
        'user_id',
        'forum_id',
        'comment',
        'likes',
        'dislikes',
    ];

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function upvote()
    {
        $this->likes++;
        $this->save();
    }

    public function downvote()
    {
        $this->dislikes++;
        $this->save();
    }

    public function likes()
    {
        return $this->hasMany(ForumCommentsVotes::class, 'comment_id')->where('type', 'like');
    }

    public function dislikes()
    {
        return $this->hasMany(ForumCommentsVotes::class, 'comment_id')->where('type', 'dislike');
    }


}