<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'image_path',
        'alt_text',
        'caption',
        'sort_order',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        // Ensure only one primary image per property
        static::saving(function ($image) {
            if ($image->is_primary) {
                static::where('property_id', $image->property_id)
                    ->where('id', '!=', $image->id)
                    ->update(['is_primary' => false]);
            }
        });
    }

    // Relationships
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}