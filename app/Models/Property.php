<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'type',
        'price',
        'status',
        'square_footage',
        'bedrooms',
        'bathrooms',
        'parking_spaces',
        'year_built',
        'features',
        'featured_image',
        'is_featured',
        'is_active',
        'latitude',
        'longitude',
        'meta_description',
        'meta_keywords',
        'brochure_url',
    ];

    protected $casts = [
        'features' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($property) {
            if (empty($property->slug)) {
                $property->slug = Str::slug($property->title);
            }
        });
        
        static::updating(function ($property) {
            if ($property->isDirty('title') && empty($property->slug)) {
                $property->slug = Str::slug($property->title);
            }
        });
    }

    // Relationships
    public function images()
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(PropertyImage::class)->where('is_primary', true);
    }

    public function userSubmission()
    {
        return $this->hasOne(UserPropertySubmission::class);
    }

    // Scopes
    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeForSale(Builder $query)
    {
        return $query->where('status', 'for_sale');
    }

    public function scopeForLease(Builder $query)
    {
        return $query->where('status', 'for_lease');
    }

    public function scopeByType(Builder $query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopePriceRange(Builder $query, $min = null, $max = null)
    {
        if ($min) {
            $query->where('price', '>=', $min);
        }
        if ($max) {
            $query->where('price', '<=', $max);
        }
        return $query;
    }

    public function scopeByLocation(Builder $query, string $location)
    {
        return $query->where('city', 'like', "%{$location}%")
                    ->orWhere('state', 'like', "%{$location}%")
                    ->orWhere('address', 'like', "%{$location}%");
    }

    // Accessors & Mutators
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format((float)$this->price, 0);
    }

    public function getFullAddressAttribute()
    {
        return $this->address . ', ' . $this->city . ', ' . $this->state . ' ' . $this->postal_code;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getMainImage()
    {
        if ($this->primaryImage) {
            return $this->primaryImage->image_path;
        }
        
        if ($this->featured_image) {
            return $this->featured_image;
        }
        
        if ($this->images->count() > 0) {
            return $this->images->first()->image_path;
        }
        
        return '/images/property-placeholder.jpg';
    }

    public function getPropertyTypeLabel()
    {
        return ucfirst(str_replace('_', ' ', $this->type));
    }

    public function getStatusLabel()
    {
        return match($this->status) {
            'for_sale' => 'For Sale',
            'for_lease' => 'For Lease',
            'sold' => 'Sold',
            'leased' => 'Leased',
            default => ucfirst($this->status)
        };
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'for_sale' => 'bg-green-100 text-green-800',
            'for_lease' => 'bg-blue-100 text-blue-800',
            'sold' => 'bg-gray-100 text-gray-800',
            'leased' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getFormattedPrice()
    {
        return '$' . number_format($this->price, 0);
    }

    // Add this method to your Property model
}