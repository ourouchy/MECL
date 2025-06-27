<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'price', 'original_price', 'quantity', 'published', 'created_by', 'updated_by', 'brand_id'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }

    public function getImageAttribute()
    {
        return $this->images->count() > 0 ? $this->images->get(0)->url : null;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size')
            ->withPivot(['price', 'stock', 'original_price'])
            ->withTimestamps();
    }

    // ✅ Get Price by Size (fallback to product price)
    public function getPriceBySize($sizeId = null)
    {
        if ($sizeId) {
            $size = $this->sizes->where('id', $sizeId)->first();
            return $size ? $size->pivot->price : $this->price; // Fallback to main price
        }

        return $this->price; // Use main product price if no size is given
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function ratingCount()
    {
        return $this->reviews()->count();
    }
}
