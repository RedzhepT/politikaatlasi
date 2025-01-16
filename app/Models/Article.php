<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'content',
        'slug',
        'author_name',
        'image',
        'is_published'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class)->where('is_approved', true);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path($this->image))) {
            return asset($this->image);
        }
        
        // Varsayılan resim
        return asset('assets/img/default-article.jpg');
    }
} 