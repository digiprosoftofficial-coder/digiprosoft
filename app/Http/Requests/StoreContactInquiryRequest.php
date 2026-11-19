<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Support\Contact\SpamGuard;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactInquiryRequest extends FormRequest
{
    /** Land on the form (not the page top) when validation fails. */
    protected $redirectRoute = 'contact.show';

    protected function getRedirectUrl(): string
    {
        return parent::getRedirectUrl().'#contact-form';
    }

    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:120'],
            'business_name' => ['nullable', 'string', 'max:160'],
            'phone' => ['required', 'string', 'min:6', 'max:40', 'regex:/^[0-9+\-\s()]+$/'],
            // DNS/MX verification only in production (needs outbound DNS; avoids flaky local/test runs).
            'email' => ['required', 'string', app()->isProduction() ? 'email:rfc,dns' : 'email:rfc', 'max:190'],
            'service' => ['nullable', 'string', Rule::in(array_keys(SpamGuard::serviceOptions()))],
            'budget' => ['nullable', 'string', Rule::in(array_keys(SpamGuard::budgetOptions()))],
            'message' => ['required', 'string', 'min:20', 'max:5000'],
            'consent' => ['accepted'],

            // Anti-spam: honeypot must stay empty; time-trap token must be old enough.
            SpamGuard::HONEYPOT_FIELD => ['prohibited'],
            SpamGuard::TIMESTAMP_FIELD => ['required', 'string'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'phone.regex' => 'Please enter a valid phone number.',
            'email.email' => 'Please enter a valid email address that can receive mail.',
            'message.min' => 'Please give us a little more detail (at least 20 characters) so we can help.',
            'consent.accepted' => 'Please confirm that you agree to be contacted about your enquiry.',
            SpamGuard::HONEYPOT_FIELD.'.prohibited' => 'Your submission could not be processed.',
        ];
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return [
            'business_name' => 'business name',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim((string) $this->input('name')),
            'email' => strtolower(trim((string) $this->input('email'))),
            'phone' => trim((string) $this->input('phone')),
        ]);
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            if (! SpamGuard::isTimestampValid((string) $this->input(SpamGuard::TIMESTAMP_FIELD))) {
                $validator->errors()->add('message', 'The form was submitted too quickly or has expired. Please try again.');
            }

            if (SpamGuard::looksLikeSpam((string) $this->input('message'))) {
                $validator->errors()->add('message', 'Your message could not be sent. Please remove links and try again, or contact us directly.');
            }
        });
    }
}
