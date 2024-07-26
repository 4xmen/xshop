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
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function approved_children()
    {
        return $this->hasMany(Comment::class, 'sub_comment_id')->where('status', 1);
    }

    public function commentator()
    {
        if ($this->commentator_type == null) {
            return [
                'name' => $this->name,
                'email' => $this->email,
                'url' => '',
            ];
        }

        if ($this->commentator_type == Customer::class) {
            $c = Customer::whereId($this->commentator_id)->first();
            return [
                'name' => $c->name,
                'email' => $c->email,
                'url' => route('admin.customer.edit', $c->id)
            ];
        }
        if ($this->commentator_type == User::class) {
            $c = User::whereId($this->commentator_id)->first();
            return [
                'name' => $c->name,
                'email' => $c->email,
                'url' => route('admin.user.edit',$c->email)
            ];
        }

    }
}
