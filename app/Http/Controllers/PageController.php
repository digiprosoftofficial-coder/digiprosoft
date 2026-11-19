<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Service;
use App\Support\Content\ContentCache;
use App\Support\Seo\Schema;
use App\Support\Seo\SeoMeta;
use App\Support\Site;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $services = ContentCache::rememberModels('about.services', Service::query()->published()->ordered());

        $url = route('about');
        $description = 'DigiProSoft is a software development company in Dhaka, Bangladesh building business management software, websites, e-commerce platforms and custom solutions for small and medium businesses.';

        $seo = SeoMeta::make('About DigiProSoft — Software Company in Dhaka, Bangladesh', $description)
            ->canonical($url)
            ->breadcrumbs([
                ['name' => 'Home', 'url' => Site::url('/')],
                ['name' => 'About', 'url' => $url],
            ])
            ->withSchema(Schema::webPage($url, 'About DigiProSoft', $description, 'AboutPage'));

        return view('pages.about', compact('services', 'seo'));
    }

    public function faq(): View
    {
        $groups = ContentCache::rememberModels('faq.all', Faq::query()->active())->groupBy('group');

        $labels = [
            'general' => 'Working with DigiProSoft',
            'products' => 'Products',
            'services' => 'Development services',
            'pricing' => 'Pricing & payment',
            'support' => 'Support & maintenance',
        ];

        $url = route('faq');
        $description = 'Answers to common questions about DigiProSoft products, custom software development, pricing, timelines, support and how projects are delivered.';

        $seo = SeoMeta::make('Frequently Asked Questions', $description)
            ->canonical($url)
            ->breadcrumbs([
                ['name' => 'Home', 'url' => Site::url('/')],
                ['name' => 'FAQ', 'url' => $url],
            ])
            ->withSchema(Schema::webPage($url, 'FAQ', $description))
            ->withSchema(Schema::faqPage($groups->flatten(1), $url));

        return view('pages.faq', compact('groups', 'labels', 'seo'));
    }

    public function privacy(): View
    {
        $url = route('privacy');
        $description = 'How DigiProSoft collects, uses and protects personal information submitted through this website and our software products.';

        $seo = SeoMeta::make('Privacy Policy', $description)
            ->canonical($url)
            ->breadcrumbs([
                ['name' => 'Home', 'url' => Site::url('/')],
                ['name' => 'Privacy Policy', 'url' => $url],
            ])
            ->withSchema(Schema::webPage($url, 'Privacy Policy', $description));

        return view('pages.privacy', compact('seo'));
    }

    public function terms(): View
    {
        $url = route('terms');
        $description = 'Terms and conditions for using the DigiProSoft website and engaging DigiProSoft for software products and development services.';

        $seo = SeoMeta::make('Terms & Conditions', $description)
            ->canonical($url)
            ->breadcrumbs([
                ['name' => 'Home', 'url' => Site::url('/')],
                ['name' => 'Terms & Conditions', 'url' => $url],
            ])
            ->withSchema(Schema::webPage($url, 'Terms & Conditions', $description));

        return view('pages.terms', compact('seo'));
    }
}
