<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Models\Faq;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use App\Support\Content\ContentCache;
use App\Support\Seo\Schema;
use App\Support\Seo\SeoMeta;
use App\Support\Site;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $products = ContentCache::rememberModels('home.products', Product::query()
            ->published()->featured()->ordered()->with('category')->limit(6));

        $services = ContentCache::rememberModels('home.services', Service::query()
            ->published()->ordered()->limit(7));

        $caseStudies = ContentCache::rememberModels('home.case_studies', CaseStudy::query()
            ->published()->featured()->ordered()->limit(3));

        $posts = ContentCache::rememberModels('home.posts', Post::query()
            ->published()->with('category')->latest('published_at')->limit(3));

        $faqs = ContentCache::rememberModels('home.faqs', Faq::query()
            ->active()->where('group', 'general')->limit(6));

        $url = Site::url();
        $seo = SeoMeta::make(config('site.seo.default_title'), config('site.seo.default_description'))
            ->rawTitle()
            ->canonical($url.'/')
            ->withSchema(Schema::webPage($url.'/', Site::name(), config('site.seo.default_description')))
            ->withSchema(Schema::faqPage($faqs, $url.'/'));

        return view('pages.home', compact('products', 'services', 'caseStudies', 'posts', 'faqs', 'seo'));
    }
}
