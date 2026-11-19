<?php

namespace Tests\Feature\Pages;

use App\Models\CaseStudy;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public static function staticPages(): array
    {
        return [
            'home' => ['/', 'DigiProSoft | Digital Product &amp; Software Solution'],
            'about' => ['/about', 'About DigiProSoft'],
            'products' => ['/products', 'Business Software Products'],
            'services' => ['/services', 'Software Development Services'],
            'portfolio' => ['/portfolio', 'Portfolio'],
            'blog' => ['/blog', 'Blog'],
            'contact' => ['/contact', 'Contact DigiProSoft'],
            'faq' => ['/faq', 'Frequently Asked Questions'],
            'privacy' => ['/privacy-policy', 'Privacy Policy'],
            'terms' => ['/terms-and-conditions', 'Terms'],
        ];
    }

    #[Test]
    #[DataProvider('staticPages')]
    public function core_pages_render_with_seo_essentials(string $path, string $titleFragment): void
    {
        $response = $this->get($path);

        $response->assertOk()
            ->assertSee('<title>'.$titleFragment, false)
            ->assertSee('<meta name="description"', false)
            ->assertSee('<link rel="canonical" href="'.rtrim(config('app.url'), '/').($path === '/' ? '/' : $path).'"', false)
            ->assertSee('property="og:title"', false)
            ->assertSee('name="twitter:card"', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('Skip to main content')
            ->assertDontSee('noindex');
    }

    #[Test]
    public function detail_pages_render_for_every_seeded_record(): void
    {
        foreach (Product::all() as $product) {
            $this->get("/products/{$product->slug}")->assertOk()->assertSee($product->name)->assertSee('BreadcrumbList');
        }
        foreach (Service::all() as $service) {
            $this->get("/services/{$service->slug}")->assertOk()->assertSee($service->name)->assertSee('"@type":"Service"', false);
        }
        foreach (CaseStudy::all() as $study) {
            $this->get("/portfolio/{$study->slug}")->assertOk()->assertSee($study->title);
        }
        foreach (Post::all() as $post) {
            $this->get("/blog/{$post->slug}")->assertOk()->assertSee($post->title)->assertSee('"@type":"BlogPosting"', false);
        }
    }

    #[Test]
    public function blog_post_renders_share_dialog_with_network_links(): void
    {
        $post = Post::query()->published()->first();

        $this->get("/blog/{$post->slug}")
            ->assertSee('Share this article')
            ->assertSee('data-share-open', false)
            ->assertSee('data-share-dialog', false)
            ->assertSee('data-share-copy', false)
            ->assertSee('facebook.com/sharer/sharer.php', false)
            ->assertSee('wa.me/?text=', false)
            ->assertSee('linkedin.com/sharing/share-offsite', false)
            ->assertSee('twitter.com/intent/tweet', false)
            ->assertSee('value="'.$post->url().'"', false);
    }

    #[Test]
    public function blog_share_links_encode_a_dangerous_post_title(): void
    {
        $post = Post::query()->published()->first();
        $post->update(['title' => 'Tips & "quotes" <script>alert(1)</script>']);

        $html = $this->get("/blog/{$post->slug}")->getContent();

        $this->assertStringNotContainsString('<script>alert(1)</script>', $html);
        $this->assertStringContainsString('Share this article', $html);
        $this->assertStringContainsString('facebook.com/sharer/sharer.php', $html);
    }

    #[Test]
    public function product_page_emits_software_application_and_faq_schema(): void
    {
        $this->get('/products/pharmacy-management-system')
            ->assertOk()
            ->assertSee('"@type":"SoftwareApplication"', false)
            ->assertSee('"@type":"FAQPage"', false)
            ->assertSee('<title>SoftoPharma – Pharmacy Management Software in Bangladesh | DigiProSoft</title>', false);
    }

    #[Test]
    public function unpublished_content_is_not_reachable(): void
    {
        $product = Product::first();
        $product->update(['is_active' => false]);

        $this->get("/products/{$product->slug}")->assertNotFound();
    }

    #[Test]
    public function unknown_pages_return_branded_404(): void
    {
        $this->get('/this-page-does-not-exist')
            ->assertNotFound()
            ->assertSee('Page not found')
            ->assertSee('Back to homepage');
    }

    #[Test]
    public function trailing_slashes_and_uppercase_paths_redirect_permanently(): void
    {
        // The HTTP test helper normalises URIs, so drive the kernel directly.
        $kernel = $this->app->make(Kernel::class);

        $response = $kernel->handle(Request::create('http://localhost/about/', 'GET'));
        $this->assertSame(301, $response->getStatusCode());
        $this->assertSame('http://localhost/about', $response->headers->get('Location'));

        $response = $kernel->handle(Request::create('http://localhost/Products?ref=x', 'GET'));
        $this->assertSame(301, $response->getStatusCode());
        $this->assertSame('http://localhost/products?ref=x', $response->headers->get('Location'));

        $response = $kernel->handle(Request::create('http://localhost/', 'GET'));
        $this->assertSame(200, $response->getStatusCode(), 'Root must not redirect');
    }

    #[Test]
    public function security_headers_are_present(): void
    {
        $this->get('/')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Content-Security-Policy');
    }

    #[Test]
    public function page_titles_and_descriptions_are_unique_across_the_site(): void
    {
        $paths = array_map(fn ($row) => $row[0], self::staticPages());
        $paths = [...$paths, ...Product::pluck('slug')->map(fn ($s) => "/products/$s")->all()];
        $paths = [...$paths, ...Service::pluck('slug')->map(fn ($s) => "/services/$s")->all()];
        $paths = [...$paths, ...Post::pluck('slug')->map(fn ($s) => "/blog/$s")->all()];

        $titles = [];
        $descriptions = [];
        foreach ($paths as $path) {
            $html = $this->get($path)->getContent();
            preg_match('/<title>(.*?)<\/title>/s', $html, $t);
            preg_match('/<meta name="description" content="(.*?)">/s', $html, $d);
            $titles[$path] = $t[1] ?? '';
            $descriptions[$path] = $d[1] ?? '';
        }

        $this->assertSame(count($titles), count(array_unique($titles)), 'Duplicate titles: '.json_encode(array_diff_assoc($titles, array_unique($titles))));
        $this->assertSame(count($descriptions), count(array_unique($descriptions)), 'Duplicate descriptions: '.json_encode(array_diff_assoc($descriptions, array_unique($descriptions))));
    }
}
