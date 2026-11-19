<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Product;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SeoInfrastructureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    #[Test]
    public function sitemap_lists_every_public_url_and_nothing_private(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk()->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $xml = simplexml_load_string($response->getContent());
        $this->assertNotFalse($xml, 'Sitemap must be valid XML');

        $locs = collect(iterator_to_array($xml->url, false))->map(fn ($u) => (string) $u->loc);

        $this->assertTrue($locs->contains(rtrim(url('/'), '/').'/'), 'Homepage must be listed with a trailing slash');
        $this->assertTrue($locs->contains(url('/products')));
        $this->assertTrue($locs->contains(url('/contact')));
        Product::all()->each(fn ($p) => $this->assertTrue($locs->contains(url("/products/{$p->slug}")), "Missing {$p->slug}"));
        Post::all()->each(fn ($p) => $this->assertTrue($locs->contains(url("/blog/{$p->slug}")), "Missing {$p->slug}"));

        $this->assertFalse($locs->contains(fn ($l) => str_contains($l, 'login') || str_contains($l, 'admin') || str_contains($l, '?')));
        $this->assertSame($locs->count(), $locs->unique()->count(), 'Sitemap must not contain duplicates');
    }

    #[Test]
    public function sitemap_excludes_unpublished_records(): void
    {
        $product = Product::first();
        $product->update(['published_at' => now()->addWeek()]);

        $this->get('/sitemap.xml')->assertDontSee(url("/products/{$product->slug}"));
    }

    #[Test]
    public function robots_blocks_everything_outside_production(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee('Disallow: /');
    }

    #[Test]
    public function robots_in_production_allows_crawling_and_references_sitemap(): void
    {
        $this->app->detectEnvironment(fn () => 'production');

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Allow: /')
            ->assertSee('Disallow: /admin')
            ->assertSee('Disallow: /login')
            ->assertSee('Sitemap: '.url('/sitemap.xml'))
            ->assertDontSee('Disallow: /build');
    }

    #[Test]
    public function json_ld_graph_is_valid_and_includes_organization_and_website(): void
    {
        $html = $this->get('/')->getContent();
        preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $m);

        $graph = json_decode($m[1], true, 512, JSON_THROW_ON_ERROR);

        $this->assertSame('https://schema.org', $graph['@context']);
        $types = collect($graph['@graph'])->pluck('@type');
        $this->assertTrue($types->contains('Organization'));
        $this->assertTrue($types->contains('WebSite'));
        $this->assertTrue($types->contains('WebPage'));
        $this->assertTrue($types->contains('FAQPage'));

        // No fabricated data: no ratings, reviews or addresses unless configured.
        $this->assertStringNotContainsString('aggregateRating', $m[1]);
        $this->assertStringNotContainsString('"review"', $m[1]);
        $this->assertStringNotContainsString('PostalAddress', $m[1]);
    }

    #[Test]
    public function blog_pagination_is_canonical_and_out_of_range_pages_404(): void
    {
        $this->get('/blog?page=99')->assertNotFound();
        $this->get('/blog?page=1')->assertOk()->assertSee('<link rel="canonical" href="'.url('/blog').'"', false);
    }

    #[Test]
    public function query_string_variants_keep_the_clean_canonical(): void
    {
        $this->get('/contact?intent=demo&service=pos-system')
            ->assertOk()
            ->assertSee('<link rel="canonical" href="'.url('/contact').'"', false);
    }
}
