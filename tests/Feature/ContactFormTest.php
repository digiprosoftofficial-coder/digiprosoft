<?php

namespace Tests\Feature;

use App\Mail\ContactInquiryReceived;
use App\Models\ContactInquiry;
use App\Support\Contact\SpamGuard;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Rahim Uddin',
            'business_name' => 'Rahim Pharmacy',
            'phone' => '01711000000',
            'email' => 'rahim@example.com',
            'service' => 'pharmacy-management-system',
            'budget' => '50k-150k',
            'message' => 'We run a pharmacy in Mirpur and want to move from notebooks to software for billing and stock.',
            'consent' => '1',
            SpamGuard::HONEYPOT_FIELD => '',
            SpamGuard::TIMESTAMP_FIELD => Crypt::encryptString((string) now()->subSeconds(10)->timestamp),
        ], $overrides);
    }

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('contact-form');
    }

    #[Test]
    public function contact_page_renders_the_form_with_csrf_and_anti_spam_fields(): void
    {
        $this->get('/contact')
            ->assertOk()
            ->assertSee('name="_token"', false)
            ->assertSee('name="'.SpamGuard::HONEYPOT_FIELD.'"', false)
            ->assertSee('name="'.SpamGuard::TIMESTAMP_FIELD.'"', false)
            ->assertSee('<label for="name"', false)
            ->assertSee('<label for="email"', false);
    }

    #[Test]
    public function valid_submission_is_stored_and_notification_sent(): void
    {
        Mail::fake();
        config(['site.contact.inquiry_recipient' => 'sales@example.test']);

        $this->from('/contact')
            ->post('/contact', $this->validPayload())
            ->assertRedirect('/contact#contact-form')
            ->assertSessionHas('status');

        $this->assertDatabaseHas('contact_inquiries', [
            'email' => 'rahim@example.com',
            'service' => 'pharmacy-management-system',
            'status' => ContactInquiry::STATUS_NEW,
        ]);

        Mail::assertSent(ContactInquiryReceived::class, fn ($mail) => $mail->hasTo('sales@example.test'));
    }

    #[Test]
    public function success_state_replaces_the_form_after_submission(): void
    {
        Mail::fake();

        $this->followingRedirects()
            ->post('/contact', $this->validPayload())
            ->assertOk()
            ->assertSee('Message received')
            ->assertSee('your message has been received')
            ->assertDontSee('<form id="contact-form"', false);

        // A fresh visit (flash consumed) shows the form again.
        $this->get('/contact')->assertSee('<form id="contact-form"', false);
    }

    #[Test]
    public function submission_is_stored_even_when_no_recipient_is_configured(): void
    {
        Mail::fake();
        config(['site.contact.inquiry_recipient' => '', 'site.contact.email' => '']);

        $this->post('/contact', $this->validPayload())->assertRedirect();

        $this->assertDatabaseCount('contact_inquiries', 1);
        Mail::assertNothingSent();
    }

    #[Test]
    public function server_side_validation_rejects_bad_input(): void
    {
        $this->from('/contact')
            ->post('/contact', $this->validPayload(['name' => '', 'email' => 'not-an-email', 'phone' => 'abc', 'message' => 'short', 'consent' => null]))
            ->assertRedirect('/contact#contact-form') // lands on the form, not the page top
            ->assertSessionHasErrors(['name', 'email', 'phone', 'message', 'consent']);

        $this->assertDatabaseCount('contact_inquiries', 0);
    }

    #[Test]
    public function honeypot_submissions_are_rejected(): void
    {
        $this->post('/contact', $this->validPayload([SpamGuard::HONEYPOT_FIELD => 'http://spam.example']))
            ->assertSessionHasErrors(SpamGuard::HONEYPOT_FIELD);

        $this->assertDatabaseCount('contact_inquiries', 0);
    }

    #[Test]
    public function instant_submissions_are_rejected_by_the_time_trap(): void
    {
        $this->post('/contact', $this->validPayload([SpamGuard::TIMESTAMP_FIELD => Crypt::encryptString((string) now()->timestamp)]))
            ->assertSessionHasErrors('message');

        $this->post('/contact', $this->validPayload([SpamGuard::TIMESTAMP_FIELD => 'tampered']))
            ->assertSessionHasErrors('message');

        $this->assertDatabaseCount('contact_inquiries', 0);
    }

    #[Test]
    public function link_heavy_messages_are_rejected(): void
    {
        $this->post('/contact', $this->validPayload(['message' => 'Buy now http://a.example http://b.example http://c.example cheap offers']))
            ->assertSessionHasErrors('message');
    }

    #[Test]
    public function unknown_service_and_budget_values_are_rejected(): void
    {
        $this->post('/contact', $this->validPayload(['service' => 'hack', 'budget' => 'infinite']))
            ->assertSessionHasErrors(['service', 'budget']);
    }

    #[Test]
    public function submissions_are_rate_limited_per_ip(): void
    {
        Mail::fake();

        for ($i = 0; $i < 5; $i++) {
            $this->post('/contact', $this->validPayload(['email' => "user{$i}@example.com"]))->assertRedirect();
        }

        $this->post('/contact', $this->validPayload())->assertStatus(429);
    }

    #[Test]
    public function submitting_without_csrf_token_is_rejected(): void
    {
        $this->app['env'] = 'production'; // ensure VerifyCsrfToken is not bypassed
        $this->withMiddleware(ValidateCsrfToken::class);

        $this->post('/contact', $this->validPayload())->assertStatus(419);
    }
}
