<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = [
        'title',
        'slug',
        'author',
        'category_id',
        'description',
        'status',
        'file_path',
        'cover_image',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $appends = [
        'cover_image_url',
        'file_path_url',
        'image_url', // alias untuk cover_image_url (backward compatibility)
    ];

    protected static function booted()
    {
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }

    public function getCoverImageUrlAttribute()
    {
        if (!$this->cover_image) {
            return null;
        }
        return asset('storage/' . $this->cover_image);
    }

    public function getImageUrlAttribute()
    {
        // Alias untuk backward compatibility
        return $this->getCoverImageUrlAttribute();
    }

    public function getFilePathUrlAttribute()
    {
        if (!$this->file_path) {
            return null;
        }
        return asset('storage/' . $this->file_path);
    }
}
