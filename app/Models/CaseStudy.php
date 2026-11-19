<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CaseStudy extends Model
{
    use HasFactory;
    use Publishable;

    protected $fillable = [
        'category_id', 'product_id', 'title', 'slug', 'client_type', 'industry', 'summary',
        'problem', 'solution', 'features', 'technologies', 'screenshots', 'outcome',
        'featured_image', 'featured_image_alt',
        'seo_title', 'seo_description', 'canonical_url', 'og_image',
        'is_featured', 'is_active', 'sort_order', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'technologies' => 'array',
            'screenshots' => 'array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    public function url(): string
    {
        return route('portfolio.show', $this);
    }
}
