<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactInquiryRequest;
use App\Mail\ContactInquiryReceived;
use App\Models\ContactInquiry;
use App\Models\Faq;
use App\Support\Contact\SpamGuard;
use App\Support\Content\ContentCache;
use App\Support\Seo\Schema;
use App\Support\Seo\SeoMeta;
use App\Support\Site;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function show(Request $request): View
    {
        $intent = $request->query('intent');
        $preselected = $request->query('service');

        $faqs = ContentCache::rememberModels('contact.faqs', Faq::query()->active()->where('group', 'pricing')->limit(4));

        $url = route('contact.show');
        $description = 'Contact DigiProSoft for a free consultation, product demo or project quote. Tell us about your business and we will recommend the right software solution.';

        $seo = SeoMeta::make('Contact DigiProSoft — Free Consultation, Demo or Quote', $description)
            ->canonical($url)
            ->breadcrumbs([
                ['name' => 'Home', 'url' => Site::url('/')],
                ['name' => 'Contact', 'url' => $url],
            ])
            ->withSchema(Schema::webPage($url, 'Contact', $description, 'ContactPage'));

        return view('contact.show', [
            'seo' => $seo,
            'faqs' => $faqs,
            'intent' => in_array($intent, ['quote', 'demo'], true) ? $intent : null,
            'preselected' => array_key_exists((string) $preselected, SpamGuard::serviceOptions()) ? $preselected : null,
            'serviceOptions' => SpamGuard::serviceOptions(),
            'budgetOptions' => SpamGuard::budgetOptions(),
            'formToken' => SpamGuard::token(),
        ]);
    }

    public function store(StoreContactInquiryRequest $request): RedirectResponse
    {
        $inquiry = ContactInquiry::create([
            ...$request->safe()->only(['name', 'business_name', 'phone', 'email', 'service', 'budget', 'message']),
            'ip_address' => $request->ip(),
            'user_agent' => str($request->userAgent() ?? '')->limit(500)->toString(),
            'referrer' => str($request->headers->get('referer', ''))->limit(500)->toString(),
            'status' => ContactInquiry::STATUS_NEW,
        ]);

        $this->notify($inquiry);

        return redirect()
            ->route('contact.show')
            ->with('status', 'Thank you — your message has been received. We usually reply within one business day.')
            ->withFragment('contact-form');
    }

    private function notify(ContactInquiry $inquiry): void
    {
        $recipient = config('site.contact.inquiry_recipient') ?: Site::email();

        if (! $recipient) {
            Log::info('Contact inquiry stored (no notification recipient configured).', ['id' => $inquiry->id]);

            return;
        }

        try {
            Mail::to($recipient)->send(new ContactInquiryReceived($inquiry));
        } catch (Throwable $e) {
            // Never surface mail transport failures to the visitor; the lead is already stored.
            Log::error('Failed to send contact inquiry notification.', ['id' => $inquiry->id, 'error' => $e->getMessage()]);
        }
    }
}
