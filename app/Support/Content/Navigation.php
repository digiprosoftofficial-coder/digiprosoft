<?php

declare(strict_types=1);

namespace App\Support\Content;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Collection;

/**
 * Cached navigation data shared by the header, footer and mobile menu.
 */
final class Navigation
{
    /** @return array<int, array{label: string, route: string, active: string}> */
    public static function primary(): array
    {
        return [
            ['label' => 'Products', 'route' => 'products.index', 'active' => 'products.*'],
            ['label' => 'Services', 'route' => 'services.index', 'active' => 'services.*'],
            ['label' => 'Portfolio', 'route' => 'portfolio.index', 'active' => 'portfolio.*'],
            ['label' => 'Blog', 'route' => 'blog.index', 'active' => 'blog.*'],
            ['label' => 'About', 'route' => 'about', 'active' => 'about'],
            ['label' => 'Contact', 'route' => 'contact.show', 'active' => 'contact.*'],
        ];
    }

    /** @return Collection<int, array{name: string, slug: string, tagline: string|null, icon: string|null}> */
    public static function products(): Collection
    {
        // Plain arrays only: the cache store never has to unserialize objects.
        return collect(ContentCache::remember('nav.products', fn () => Product::query()
            ->published()->ordered()
            ->get(['id', 'name', 'slug', 'tagline', 'icon'])
            ->map(fn (Product $p) => ['name' => $p->name, 'slug' => $p->slug, 'tagline' => $p->tagline, 'icon' => $p->icon])
            ->all()
        ));
    }

    /** @return Collection<int, array{name: string, slug: string, tagline: string|null, icon: string|null}> */
    public static function services(): Collection
    {
        return collect(ContentCache::remember('nav.services', fn () => Service::query()
            ->published()->ordered()
            ->get(['id', 'name', 'slug', 'tagline', 'icon'])
            ->map(fn (Service $s) => ['name' => $s->name, 'slug' => $s->slug, 'tagline' => $s->tagline, 'icon' => $s->icon])
            ->all()
        ));
    }
}
