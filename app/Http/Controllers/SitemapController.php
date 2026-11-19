<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use App\Support\Content\ContentCache;
use App\Support\Site;
use Carbon\CarbonInterface;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $xml = ContentCache::remember('sitemap.xml', fn () => $this->build(), 1800);

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=1800',
        ]);
    }

    private function build(): string
    {
        $products = Product::query()->published()->ordered()->get(['slug', 'updated_at']);
        $services = Service::query()->published()->ordered()->get(['slug', 'updated_at']);
        $studies = CaseStudy::query()->published()->ordered()->get(['slug', 'updated_at']);
        $posts = Post::query()->published()->latest('published_at')->get(['slug', 'updated_at', 'published_at']);

        $latest = fn ($collection, string $column = 'updated_at') => $collection->max($column);

        $entries = [
            $this->entry(Site::url('/'), collect([$latest($products), $latest($services), $latest($posts)])->filter()->max(), 'weekly', '1.0'),
            $this->entry(route('about'), null, 'monthly', '0.7'),
            $this->entry(route('products.index'), $latest($products), 'weekly', '0.9'),
            ...$products->map(fn ($p) => $this->entry(route('products.show', $p->slug), $p->updated_at, 'monthly', '0.9')),
            $this->entry(route('services.index'), $latest($services), 'weekly', '0.9'),
            ...$services->map(fn ($s) => $this->entry(route('services.show', $s->slug), $s->updated_at, 'monthly', '0.8')),
            $this->entry(route('portfolio.index'), $latest($studies), 'monthly', '0.7'),
            ...$studies->map(fn ($c) => $this->entry(route('portfolio.show', $c->slug), $c->updated_at, 'monthly', '0.6')),
            $this->entry(route('blog.index'), $latest($posts), 'weekly', '0.8'),
            ...$posts->map(fn ($p) => $this->entry(route('blog.show', $p->slug), $p->updated_at ?? $p->published_at, 'monthly', '0.7')),
            $this->entry(route('faq'), null, 'monthly', '0.6'),
            $this->entry(route('contact.show'), null, 'yearly', '0.8'),
            ...collect(SeoLandingController::slugs())->map(function (string $slug) {
                $priority = (string) (config("seo-landings.{$slug}.priority") ?? '0.8');

                return $this->entry(route('seo.landing', $slug), null, 'monthly', $priority);
            }),
            $this->entry(route('privacy'), null, 'yearly', '0.2'),
            $this->entry(route('terms'), null, 'yearly', '0.2'),
        ];

        $body = implode('', $entries);

        return '<?xml version="1.0" encoding="UTF-8"?>'."\n"
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n"
            .$body
            .'</urlset>';
    }

    private function entry(string $loc, ?CarbonInterface $lastmod, string $changefreq, string $priority): string
    {
        $xml = '  <url>'."\n".'    <loc>'.e($loc).'</loc>'."\n";
        if ($lastmod) {
            $xml .= '    <lastmod>'.$lastmod->toDateString().'</lastmod>'."\n";
        }
        $xml .= '    <changefreq>'.$changefreq.'</changefreq>'."\n";
        $xml .= '    <priority>'.$priority.'</priority>'."\n";

        return $xml.'  </url>'."\n";
    }
}
