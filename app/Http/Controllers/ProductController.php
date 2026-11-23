<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Support\Content\ContentCache;
use App\Support\Seo\Schema;
use App\Support\Seo\SeoMeta;
use App\Support\Site;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = ContentCache::rememberModels('products.index', Product::query()
            ->published()->ordered()->with('category'));

        $categories = ContentCache::rememberModels('products.categories', Category::query()
            ->ofType(Category::TYPE_PRODUCT));

        $url = route('products.index');
        $description = 'Explore DigiProSoft software products for pharmacies, hotels, schools, retail shops and online stores in Bangladesh — pharmacy, hotel, school, POS and e-commerce systems, plus custom business software.';

        $seo = SeoMeta::make('Business Software Products for Bangladesh', $description)
            ->canonical($url)
            ->breadcrumbs([
                ['name' => __('Home'), 'url' => Site::url('/')],
                ['name' => __('Products'), 'url' => $url],
            ])
            ->withSchema(Schema::webPage($url, 'Products', $description, 'CollectionPage'))
            ->withSchema(Schema::itemList('DigiProSoft products', $products->map(fn (Product $p) => ['name' => $p->name, 'url' => $p->url()])));

        return view('products.index', compact('products', 'categories', 'seo'));
    }

    public function show(string $product): View
    {
        $product = Product::query()
            ->published()
            ->where('slug', $product)
            ->with([
                'category',
                'services' => fn ($q) => $q->published()->ordered(),
            ])
            ->firstOrFail();

        $relatedProducts = ContentCache::rememberModels("products.related.{$product->id}", Product::query()
            ->published()->with('category')
            ->whereKeyNot($product->id)
            ->when($product->category_id, fn ($q) => $q->orderByRaw('CASE WHEN category_id = ? THEN 0 ELSE 1 END', [$product->category_id]))
            ->ordered()
            ->limit(3));

        $relatedPosts = ContentCache::rememberModels("products.posts.{$product->id}", Post::query()
            ->published()->with('category')
            ->whereHas('products', fn ($q) => $q->whereKey($product->id))
            ->latest('published_at')->limit(3));

        $url = $product->canonical_url ?: $product->url();
        $breadcrumbs = [
            ['name' => __('Home'), 'url' => Site::url('/')],
            ['name' => __('Products'), 'url' => route('products.index')],
            ['name' => $product->name, 'url' => $url],
        ];

        $seo = SeoMeta::make($product->seoTitle(), $product->seoDescription())
            ->canonical($url)
            ->image($product->ogImage())
            ->breadcrumbs($breadcrumbs)
            ->withSchema(Schema::webPage($url, $product->name, $product->seoDescription(), 'ItemPage'))
            ->withSchema(Schema::softwareApplication($product))
            ->withSchema(Schema::faqPage($product->faqs ?? [], $url));

        return view('products.show', compact('product', 'relatedProducts', 'relatedPosts', 'breadcrumbs', 'seo'));
    }
}
