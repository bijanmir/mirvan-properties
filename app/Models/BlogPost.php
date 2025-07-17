<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'featured_image_alt',
        'is_published',
        'is_featured',
        'published_at',
        'meta_description',
        'meta_keywords',
        'tags',
        'author_name',
        'read_time',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'tags' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            
            if (empty($post->excerpt)) {
                $post->excerpt = Str::limit(strip_tags($post->content), 160);
            }
            
            if (empty($post->read_time)) {
                $post->read_time = $post->calculateReadTime();
            }
        });
        
        static::updating(function ($post) {
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            
            if ($post->isDirty('content')) {
                if (empty($post->excerpt)) {
                    $post->excerpt = Str::limit(strip_tags($post->content), 160);
                }
                $post->read_time = $post->calculateReadTime();
            }
        });
    }

    // Scopes
    public function scopePublished(Builder $query)
    {
        return $query->where('is_published', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured(Builder $query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRecent(Builder $query, int $limit = 5)
    {
        return $query->orderBy('published_at', 'desc')->limit($limit);
    }

    public function scopeByTag(Builder $query, string $tag)
    {
        return $query->whereJsonContains('tags', $tag);
    }

    // Accessors
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getFormattedPublishedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('M j, Y') : null;
    }

    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image ? asset('storage/' . $this->featured_image) : null;
    }

    public function getTagsListAttribute()
    {
        return $this->tags ? implode(', ', $this->tags) : '';
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function publish()
    {
        $this->update([
            'is_published' => true,
            'published_at' => now(),
        ]);
    }

    public function unpublish()
    {
        $this->update([
            'is_published' => false,
        ]);
    }

    private function calculateReadTime()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return max(1, ceil($wordCount / 200)); // Assuming 200 words per minute
    }

    public function getReadTimeTextAttribute()
    {
        return $this->read_time . ' min read';
    }
}