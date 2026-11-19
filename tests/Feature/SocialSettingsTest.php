<?php

namespace Tests\Feature;

use App\Filament\Pages\SocialSettings;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SocialSettingsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function guests_are_redirected_from_social_settings(): void
    {
        $this->get('/admin/social')->assertRedirect('/admin/login');
    }

    #[Test]
    public function authenticated_users_can_open_social_settings(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/admin/social')->assertOk();
    }

    #[Test]
    public function saved_social_urls_appear_on_the_public_site(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(SocialSettings::class)
            ->fillForm([
                'facebook' => 'https://www.facebook.com/digiprosoft',
                'linkedin' => 'https://www.linkedin.com/company/digiprosoft',
                'youtube' => '',
                'x' => '',
                'github' => '',
                'twitter_handle' => 'digiprosoft',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('site_settings', [
            'facebook' => 'https://www.facebook.com/digiprosoft',
            'linkedin' => 'https://www.linkedin.com/company/digiprosoft',
            'youtube' => null,
            'twitter_handle' => 'digiprosoft',
        ]);

        $this->get('/')
            ->assertSee('https://www.facebook.com/digiprosoft', false)
            ->assertSee('https://www.linkedin.com/company/digiprosoft', false)
            ->assertSee('name="twitter:site" content="@digiprosoft"', false)
            ->assertDontSee('https://www.youtube.com', false);
    }

    #[Test]
    public function rejects_an_invalid_social_url(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(SocialSettings::class)
            ->fillForm([
                'facebook' => 'not-a-url',
            ])
            ->call('save')
            ->assertHasFormErrors(['facebook']);

        $this->assertDatabaseCount('site_settings', 0);
    }

    #[Test]
    public function empty_saved_profiles_hide_footer_icons(): void
    {
        SiteSetting::query()->create([
            'facebook' => 'https://www.facebook.com/digiprosoft',
        ]);

        $this->actingAs(User::factory()->create());

        Livewire::test(SocialSettings::class)
            ->fillForm([
                'facebook' => '',
                'linkedin' => '',
                'youtube' => '',
                'x' => '',
                'github' => '',
                'twitter_handle' => '',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->get('/')
            ->assertDontSee('https://www.facebook.com/digiprosoft', false)
            ->assertDontSee('aria-label="Social media"', false);
    }
}
