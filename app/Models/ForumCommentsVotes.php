<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumCommentsVotes extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'comment_id',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function forumComment()
    {
        return $this->belongsTo(ForumComments::class);
    }
}