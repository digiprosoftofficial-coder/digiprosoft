<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Models\Post;
use App\Models\Service;
use App\Support\Content\ContentCache;
use App\Support\Seo\Schema;
use App\Support\Seo\SeoMeta;
use App\Support\Site;
use Illuminate\Contracts\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = ContentCache::rememberModels('services.index', Service::query()
            ->published()->ordered());

        $url = route('services.index');
        $description = 'Software development services from DigiProSoft: custom software, web and e-commerce development, business automation, API integration, SaaS development and long-term software maintenance for businesses in Bangladesh.';

        $seo = SeoMeta::make('Software Development Services in Bangladesh', $description)
            ->canonical($url)
            ->breadcrumbs([
                ['name' => __('Home'), 'url' => Site::url('/')],
                ['name' => __('Services'), 'url' => $url],
            ])
            ->withSchema(Schema::webPage($url, 'Services', $description, 'CollectionPage'))
            ->withSchema(Schema::itemList('DigiProSoft services', $services->map(fn (Service $s) => ['name' => $s->name, 'url' => $s->url()])));

        return view('services.index', compact('services', 'seo'));
    }

    public function show(string $service): View
    {
        $service = Service::query()
            ->published()
            ->where('slug', $service)
            ->with([
                'products' => fn ($q) => $q->published()->ordered()->with('category'),
            ])
            ->firstOrFail();

        $relatedServices = ContentCache::rememberModels("services.related.{$service->id}", Service::query()
            ->published()->ordered()->whereKeyNot($service->id)->limit(3));

        $caseStudies = ContentCache::rememberModels("services.cases.{$service->id}", CaseStudy::query()
            ->published()->ordered()
            ->whereHas('services', fn ($q) => $q->whereKey($service->id))
            ->limit(3));

        $relatedPosts = ContentCache::rememberModels("services.posts.{$service->id}", Post::query()
            ->published()->with('category')
            ->whereHas('services', fn ($q) => $q->whereKey($service->id))
            ->latest('published_at')->limit(3));

        $url = $service->canonical_url ?: $service->url();
        $breadcrumbs = [
            ['name' => __('Home'), 'url' => Site::url('/')],
            ['name' => __('Services'), 'url' => route('services.index')],
            ['name' => $service->name, 'url' => $url],
        ];

        $seo = SeoMeta::make($service->seoTitle(), $service->seoDescription())
            ->canonical($url)
            ->image($service->ogImage())
            ->breadcrumbs($breadcrumbs)
            ->withSchema(Schema::webPage($url, $service->name, $service->seoDescription()))
            ->withSchema(Schema::service($service))
            ->withSchema(Schema::faqPage($service->faqs ?? [], $url));

        return view('services.show', compact('service', 'relatedServices', 'caseStudies', 'relatedPosts', 'breadcrumbs', 'seo'));
    }
}
