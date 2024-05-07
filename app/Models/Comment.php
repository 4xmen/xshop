<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function commentable()
    {
        return $this->morphTo();
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'sub_comment_id');
    }

    public function approved_children()
    {
        return $this->hasMany(Comment::class, 'sub_comment_id')->where('status', 1);
    }
}
