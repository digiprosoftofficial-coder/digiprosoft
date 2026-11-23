<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LocaleSwitchTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function guests_can_switch_to_bangla_and_see_translated_chrome(): void
    {
        $this->from('/')
            ->get(route('locale.switch', 'bn'))
            ->assertRedirect('/')
            ->assertCookie('locale', 'bn');

        $this->withSession(['locale' => 'bn'])
            ->get('/')
            ->assertOk()
            ->assertSee('বাং', false)
            ->assertSee('পণ্য', false)
            ->assertSee('সেবা', false)
            ->assertSee('বিনামূল্যে পরামর্শ নিন', false)
            ->assertSee('lang="bn"', false);
    }

    #[Test]
    public function guests_can_switch_back_to_english(): void
    {
        $this->withSession(['locale' => 'bn'])
            ->from('/')
            ->get(route('locale.switch', 'en'))
            ->assertRedirect('/')
            ->assertCookie('locale', 'en');

        $this->withSession(['locale' => 'en'])
            ->get('/')
            ->assertOk()
            ->assertSee('Products', false)
            ->assertSee('Get a Free Consultation', false)
            ->assertSee('lang="en"', false);
    }

    #[Test]
    public function unsupported_locale_returns_not_found(): void
    {
        $this->get('/locale/fr')->assertNotFound();
    }
}
