<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    use Publishable;

    protected $fillable = [
        'category_id', 'name', 'slug', 'tagline', 'website_url', 'short_description', 'description',
        'problem', 'solution', 'target_audience', 'features', 'benefits', 'screenshots',
        'gallery', 'faqs', 'icon', 'featured_image', 'featured_image_alt',
        'seo_title', 'seo_description', 'canonical_url', 'og_image',
        'is_featured', 'is_active', 'sort_order', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'target_audience' => 'array',
            'features' => 'array',
            'benefits' => 'array',
            'screenshots' => 'array',
            'gallery' => 'array',
            'faqs' => 'array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    public function caseStudies(): HasMany
    {
        return $this->hasMany(CaseStudy::class);
    }

    public function url(): string
    {
        return route('products.show', $this);
    }
}
