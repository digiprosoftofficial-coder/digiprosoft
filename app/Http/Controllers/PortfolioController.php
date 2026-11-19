<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Support\Content\ContentCache;
use App\Support\Seo\Schema;
use App\Support\Seo\SeoMeta;
use App\Support\Site;
use Illuminate\Contracts\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $studies = ContentCache::rememberModels('portfolio.index', CaseStudy::query()
            ->published()->ordered()->with('category'));

        $url = route('portfolio.index');
        $description = 'Selected DigiProSoft projects and product implementations: pharmacy, hotel, school, POS and e-commerce systems, plus custom business software built for organisations in Bangladesh.';

        $seo = SeoMeta::make('Portfolio & Case Studies', $description)
            ->canonical($url)
            ->breadcrumbs([
                ['name' => 'Home', 'url' => Site::url('/')],
                ['name' => 'Portfolio', 'url' => $url],
            ])
            ->withSchema(Schema::webPage($url, 'Portfolio', $description, 'CollectionPage'));

        return view('portfolio.index', compact('studies', 'seo'));
    }

    public function show(string $caseStudy): View
    {
        $study = CaseStudy::query()
            ->published()
            ->where('slug', $caseStudy)
            ->with([
                'category',
                'product' => fn ($q) => $q->published(),
                'services' => fn ($q) => $q->published()->ordered(),
            ])
            ->firstOrFail();

        $related = ContentCache::rememberModels("portfolio.related.{$study->id}", CaseStudy::query()
            ->published()->ordered()->whereKeyNot($study->id)->limit(3));

        $url = $study->canonical_url ?: $study->url();
        $breadcrumbs = [
            ['name' => 'Home', 'url' => Site::url('/')],
            ['name' => 'Portfolio', 'url' => route('portfolio.index')],
            ['name' => $study->title, 'url' => $url],
        ];

        $seo = SeoMeta::make($study->seoTitle(), $study->seoDescription())
            ->canonical($url)
            ->image($study->ogImage())
            ->breadcrumbs($breadcrumbs)
            ->withSchema(Schema::webPage($url, $study->title, $study->seoDescription()))
            ->withSchema(Schema::creativeWork($study));

        return view('portfolio.show', compact('study', 'related', 'breadcrumbs', 'seo'));
    }
}
