<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Support\Content\ContentCache;
use App\Support\Seo\Schema;
use App\Support\Seo\SeoMeta;
use App\Support\Site;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public const PER_PAGE = 9;

    public function index(Request $request): View
    {
        $page = max(1, (int) $request->query('page', 1));

        $posts = Post::query()
            ->published()
            ->with(['category'])
            ->latest('published_at')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        // Out-of-range pages must 404 rather than render empty, duplicate pages.
        if ($page > 1 && $posts->isEmpty()) {
            abort(404);
        }

        // Cached as plain arrays (name + count) so the cache store never unserializes objects.
        $categories = collect(ContentCache::remember('blog.categories', fn () => Category::query()
            ->ofType(Category::TYPE_POST)->withCount(['posts' => fn ($q) => $q->published()])->get()
            ->filter(fn (Category $c) => $c->posts_count > 0)
            ->map(fn (Category $c) => ['name' => $c->name, 'slug' => $c->slug, 'posts_count' => (int) $c->posts_count])
            ->values()->all()))->map(fn (array $c) => (object) $c);

        $featured = $page === 1
            ? ContentCache::rememberModel('blog.featured', Post::query()->published()->featured()->with('category')->latest('published_at'))
            : null;

        $baseUrl = route('blog.index');
        $url = $page > 1 ? $baseUrl.'?page='.$page : $baseUrl;
        $title = $page > 1 ? "Blog & Insights — Page {$page}" : 'Blog & Insights on Business Software';
        $description = $page > 1
            ? "Page {$page} of DigiProSoft articles on business software, automation and digital transformation for companies in Bangladesh."
            : 'Practical articles from DigiProSoft on business management software, pharmacy and hotel systems, POS, e-commerce, automation and choosing the right software for your business.';

        $seo = SeoMeta::make($title, $description)
            ->canonical($url)
            ->breadcrumbs([
                ['name' => 'Home', 'url' => Site::url('/')],
                ['name' => 'Blog', 'url' => $baseUrl],
            ])
            ->withSchema(Schema::webPage($url, 'Blog', $description, 'CollectionPage'));

        return view('blog.index', compact('posts', 'categories', 'featured', 'seo', 'page'));
    }

    public function show(string $post): View
    {
        $post = Post::query()
            ->published()
            ->where('slug', $post)
            ->with([
                'category', 'author', 'tags',
                'products' => fn ($q) => $q->published()->ordered(),
                'services' => fn ($q) => $q->published()->ordered(),
            ])
            ->firstOrFail();

        $related = ContentCache::rememberModels("blog.related.{$post->id}", Post::query()
            ->published()->with('category')
            ->whereKeyNot($post->id)
            ->when($post->category_id, fn ($q) => $q->orderByRaw('CASE WHEN category_id = ? THEN 0 ELSE 1 END', [$post->category_id]))
            ->latest('published_at')
            ->limit(3));

        $url = $post->canonical_url ?: $post->url();
        $breadcrumbs = [
            ['name' => 'Home', 'url' => Site::url('/')],
            ['name' => 'Blog', 'url' => route('blog.index')],
            ['name' => $post->title, 'url' => $url],
        ];

        $seo = SeoMeta::make($post->seoTitle(), $post->seoDescription())
            ->canonical($url)
            ->image($post->ogImage())
            ->article($post->published_at?->toIso8601String(), $post->updated_at?->toIso8601String())
            ->breadcrumbs($breadcrumbs)
            ->withSchema(Schema::webPage($url, $post->title, $post->seoDescription(), 'ItemPage'))
            ->withSchema(Schema::blogPosting($post));

        return view('blog.show', compact('post', 'related', 'breadcrumbs', 'seo'));
    }
}
