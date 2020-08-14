<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'author', 'content', 'user_id', 'post_id'
    ];
}
