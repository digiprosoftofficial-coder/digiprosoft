<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use HasFactory;
    use Publishable;

    protected $fillable = [
        'category_id', 'name', 'slug', 'tagline', 'short_description', 'description',
        'problem', 'solution', 'features', 'process', 'benefits', 'technologies', 'faqs',
        'icon', 'featured_image', 'featured_image_alt',
        'seo_title', 'seo_description', 'canonical_url', 'og_image',
        'is_featured', 'is_active', 'sort_order', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'process' => 'array',
            'benefits' => 'array',
            'technologies' => 'array',
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

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function caseStudies(): BelongsToMany
    {
        return $this->belongsToMany(CaseStudy::class);
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    public function url(): string
    {
        return route('services.show', $this);
    }
}
