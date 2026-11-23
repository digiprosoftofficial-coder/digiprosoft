<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LlmsTxtController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SeoLandingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public website
|--------------------------------------------------------------------------
| Slugs are lowercase, hyphen-separated. The `slug` pattern below rejects
| anything else so we never serve duplicate URL variants.
*/

Route::pattern('product', '[a-z0-9-]+');
Route::pattern('service', '[a-z0-9-]+');
Route::pattern('caseStudy', '[a-z0-9-]+');
Route::pattern('post', '[a-z0-9-]+');

Route::get('/', HomeController::class)->name('home');

Route::get('/locale/{locale}', LocaleController::class)
    ->whereIn('locale', ['en', 'bn'])
    ->name('locale.switch');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('terms');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{caseStudy}', [PortfolioController::class, 'show'])->name('portfolio.show');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:contact-form')
    ->name('contact.store');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', RobotsController::class)->name('robots');
Route::get('/llms.txt', LlmsTxtController::class)->name('llms');

$seoLandingPattern = collect(SeoLandingController::slugs())
    ->map(fn (string $slug) => preg_quote($slug, '/'))
    ->implode('|');

if ($seoLandingPattern !== '') {
    Route::get('/{landing}', [SeoLandingController::class, 'show'])
        ->where('landing', $seoLandingPattern)
        ->name('seo.landing');
}
