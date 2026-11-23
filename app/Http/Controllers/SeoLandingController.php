<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use App\Support\Content\ContentCache;
use App\Support\Seo\Schema;
use App\Support\Seo\SeoMeta;
use App\Support\Site;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SeoLandingController extends Controller
{
    public function show(string $landing): View
    {
        $page = config("seo-landings.{$landing}");
        if (! is_array($page)) {
            throw new NotFoundHttpException;
        }

        $products = ! empty($page['show_products'])
            ? ContentCache::rememberModels(
                'seo.landing.products',
                Product::query()->published()->ordered()->with('category'),
            )
            : collect();

        $services = ! empty($page['show_services'])
            ? ContentCache::rememberModels('seo.landing.services', Service::query()->published()->ordered())
            : collect();

        $featuredProduct = null;
        if (! empty($page['featured_product_slug'])) {
            $featuredProduct = Product::query()
                ->published()
                ->where('slug', $page['featured_product_slug'])
                ->first();
        }

        $url = route('seo.landing', $landing);
        $seo = SeoMeta::make($page['title'], $page['description'])
            ->rawTitle()
            ->canonical($url)
            ->breadcrumbs([
                ['name' => __('Home'), 'url' => Site::url('/')],
                ['name' => $page['h1'], 'url' => $url],
            ])
            ->withSchema(Schema::webPage($url, $page['h1'], $page['description']))
            ->withSchema(Schema::faqPage(collect($page['faqs'] ?? []), $url));

        return view('pages.seo-landing', [
            'landing' => $landing,
            'page' => $page,
            'products' => $products,
            'services' => $services,
            'featuredProduct' => $featuredProduct,
            'seo' => $seo,
            'breadcrumbs' => [
                ['name' => __('Home'), 'url' => route('home')],
                ['name' => $page['h1'], 'url' => $url],
            ],
        ]);
    }

    /** @return list<string> */
    public static function slugs(): array
    {
        return array_keys(config('seo-landings', []));
    }
}
