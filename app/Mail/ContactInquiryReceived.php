<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\ContactInquiry;
use App\Support\Contact\SpamGuard;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactInquiryReceived extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public readonly ContactInquiry $inquiry) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: sprintf('[%s] New enquiry from %s', config('site.name'), $this->inquiry->name),
            replyTo: [new Address($this->inquiry->email, $this->inquiry->name)],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact-inquiry',
            with: [
                'inquiry' => $this->inquiry,
                'serviceLabel' => SpamGuard::serviceOptions()[$this->inquiry->service] ?? $this->inquiry->service,
                'budgetLabel' => SpamGuard::budgetOptions()[$this->inquiry->budget] ?? $this->inquiry->budget,
            ],
        );
    }
}
