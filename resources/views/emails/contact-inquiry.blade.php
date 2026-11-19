<x-mail::message>
# New enquiry from {{ $inquiry->name }}

**Name:** {{ $inquiry->name }}
@if($inquiry->business_name)
**Business:** {{ $inquiry->business_name }}
@endif
**Phone:** {{ $inquiry->phone }}
**Email:** {{ $inquiry->email }}
@if($serviceLabel)
**Interested in:** {{ $serviceLabel }}
@endif
@if($budgetLabel)
**Budget:** {{ $budgetLabel }}
@endif

---

{{ $inquiry->message }}

---

Received {{ $inquiry->created_at->format('d M Y, H:i') }} · Enquiry #{{ $inquiry->id }}

Reply directly to this email to respond to {{ $inquiry->name }}.
</x-mail::message>
