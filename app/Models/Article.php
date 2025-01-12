<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'category',
        'author_name',
        'author_image'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class)->where('is_approved', true);
    }
} 