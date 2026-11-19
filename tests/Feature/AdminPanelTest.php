<?php

namespace Tests\Feature;

use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function guests_are_redirected_to_the_admin_login_page(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    #[Test]
    public function authenticated_users_can_open_the_admin_panel(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/admin')->assertOk();

        Livewire::test(ListProducts::class)->assertOk();
    }

    #[Test]
    public function authenticated_users_can_create_a_product(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreateProduct::class)
            ->fillForm([
                'name' => 'Inventory Tracker',
                'slug' => 'inventory-tracker',
                'short_description' => 'Stock tracking for small shops.',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 10,
                'published_at' => now(),
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('products', [
            'slug' => 'inventory-tracker',
            'name' => 'Inventory Tracker',
            'is_active' => true,
        ]);

        $this->assertTrue(Product::query()->published()->where('slug', 'inventory-tracker')->exists());
    }
}
