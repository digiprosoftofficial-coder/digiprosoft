<?php

namespace Tests\Feature;

use App\Http\Controllers\SeoLandingController;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SeoDiscoverabilityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    #[Test]
    public function llms_txt_summarises_the_company_and_product_urls(): void
    {
        $this->get('/llms.txt')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee('DigiProSoft')
            ->assertSee('SoftoPharma')
            ->assertSee('https://softopharma.digiprosoft.com/', false)
            ->assertSee(url('/products/pharmacy-management-system'), false)
            ->assertSee(route('seo.landing', 'software-development-company-bangladesh'), false)
            ->assertSee('Sitemap:');
    }

    #[Test]
    public function seo_landing_pages_render_with_canonical_and_faq_schema(): void
    {
        foreach (SeoLandingController::slugs() as $slug) {
            $url = route('seo.landing', $slug);

            $this->get('/'.$slug)
                ->assertOk()
                ->assertSee('<link rel="canonical" href="'.$url.'"', false)
                ->assertSee('"@type":"FAQPage"', false)
                ->assertSee('Contact DigiProSoft');
        }
    }

    #[Test]
    public function sitemap_includes_seo_landing_pages(): void
    {
        $response = $this->get('/sitemap.xml')->assertOk();

        foreach (SeoLandingController::slugs() as $slug) {
            $response->assertSee(url('/'.$slug), false);
        }
    }

    #[Test]
    public function softopharma_schema_points_at_the_live_product_url(): void
    {
        $html = $this->get('/products/pharmacy-management-system')->getContent();
        preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $match);

        $this->assertNotEmpty($match[1] ?? null);
        $graph = json_decode($match[1], true, 512, JSON_THROW_ON_ERROR);
        $software = collect($graph['@graph'])->firstWhere('@type', 'SoftwareApplication');

        $this->assertSame('https://softopharma.digiprosoft.com/', $software['url']);
        $this->assertContains(url('/products/pharmacy-management-system'), $software['sameAs']);
    }

    #[Test]
    public function production_robots_mentions_llms_txt(): void
    {
        $this->app->detectEnvironment(fn () => 'production');

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('llms.txt')
            ->assertSee('Sitemap: '.url('/sitemap.xml'));
    }
}
