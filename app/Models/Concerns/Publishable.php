<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Support\Content\ContentCache;
use Illuminate\Database\Eloquent\Builder;

/**
 * Shared behaviour for public content models: slug routing, a
 * "published" scope, SEO fallbacks and automatic cache invalidation.
 */
trait Publishable
{
    public static function bootPublishable(): void
    {
        static::saved(fn () => ContentCache::flush());
        static::deleted(fn () => ContentCache::flush());
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function seoTitle(): string
    {
        return $this->seo_title ?: ($this->name ?? $this->title);
    }

    public function seoDescription(): string
    {
        return $this->seo_description ?: str($this->short_description ?? $this->summary ?? $this->excerpt ?? '')->limit(155)->toString();
    }

    public function ogImage(): ?string
    {
        return $this->og_image ?: $this->featured_image;
    }
}
