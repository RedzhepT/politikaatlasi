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
        'is_published',
        'category_id',
        'views'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'views' => 'integer',
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

    // Görsel URL'lerini almak için accessor
    public function getFeaturedImageUrlAttribute($size = 'medium')
    {
        $images = is_array($this->image) ? $this->image : json_decode($this->image, true);
        return $images[$size] ?? null;
    }
} 