<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductShowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    #[Test]
    public function softopharma_product_links_to_the_live_product_website(): void
    {
        $product = Product::query()->where('slug', 'pharmacy-management-system')->firstOrFail();

        $this->assertSame('SoftoPharma', $product->name);
        $this->assertSame('https://softopharma.digiprosoft.com/', $product->website_url);

        $this->get('/products/pharmacy-management-system')
            ->assertOk()
            ->assertSee('SoftoPharma')
            ->assertSee('https://softopharma.digiprosoft.com/', false)
            ->assertSee('Visit SoftoPharma')
            ->assertSee('Live product website')
            ->assertSee('Request a Demo');
    }

    #[Test]
    public function products_without_a_website_url_keep_the_standard_demo_cta(): void
    {
        $product = Product::query()->where('slug', 'hotel-management-system')->firstOrFail();

        $this->assertNull($product->website_url);

        $this->get('/products/hotel-management-system')
            ->assertOk()
            ->assertSee('Request a Demo')
            ->assertSee('Get a Quote')
            ->assertDontSee('Visit '.$product->name);
    }
}
