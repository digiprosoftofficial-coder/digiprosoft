@use('App\Support\Contact\SpamGuard')
@use('App\Support\Site')
<x-layouts.app :seo="$seo" :flash="false">
    @php
        $heading = match ($intent) {
            'demo' => __('Book a product demo'),
            'quote' => __('Request a quote'),
            default => __('Get a free consultation'),
        };
        $inputClass = 'block w-full rounded-lg border-0 bg-white px-3.5 py-3 text-ink-900 shadow-sm ring-1 ring-inset ring-ink-300 placeholder:text-ink-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6 aria-[invalid=true]:ring-red-500';
    @endphp

    <x-ui.page-hero eyebrow="{{ __('Contact') }}" :title="$heading" :breadcrumbs="[['name' => __('Home'), 'url' => route('home')], ['name' => __('Contact'), 'url' => route('contact.show')]]">
        {{ __('Tell us about your business and what you want to improve. We reply within one business day with questions, options and a clear next step.') }}
    </x-ui.page-hero>

    <section class="section" aria-label="{{ __('Contact form and details') }}">
        <div class="container-site grid gap-12 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-7">
                @if(session('status'))
                    <div id="contact-form" role="status" aria-live="polite" class="rounded-3xl border border-accent-500/30 bg-emerald-50/60 p-8 shadow-card sm:p-10">
                        <span class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                            <x-ui.icon name="check-circle" class="h-6 w-6" />
                        </span>
                        <h2 class="mt-5 text-2xl font-semibold tracking-tight text-ink-950">{{ __('Message received') }}</h2>
                        <p class="mt-3 text-ink-700">{{ session('status') }}</p>
                        <div class="mt-8 flex flex-wrap gap-3">
                            <x-ui.button href="{{ route('products.index') }}" variant="secondary">{{ __('Explore our products') }}</x-ui.button>
                            <x-ui.button href="{{ route('blog.index') }}" variant="ghost">{{ __('Read the blog') }}</x-ui.button>
                        </div>
                    </div>
                @else
                @if(session('error'))
                    <div role="alert" class="mb-6 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <x-ui.icon name="alert" class="mt-0.5 h-5 w-5 shrink-0" />
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
                <form id="contact-form" method="POST" action="{{ route('contact.store') }}" class="rounded-3xl border border-ink-200 bg-white p-6 shadow-card sm:p-8" novalidate>
                    @csrf
                    <input type="hidden" name="{{ SpamGuard::TIMESTAMP_FIELD }}" value="{{ $formToken }}">

                    <div class="absolute -left-[10000px] top-auto h-px w-px overflow-hidden" aria-hidden="true">
                        <label for="{{ SpamGuard::HONEYPOT_FIELD }}">{{ __('Leave this field empty') }}</label>
                        <input type="text" id="{{ SpamGuard::HONEYPOT_FIELD }}" name="{{ SpamGuard::HONEYPOT_FIELD }}" tabindex="-1" autocomplete="off" value="">
                    </div>

                    @if($errors->any())
                        <div role="alert" class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                            <p class="font-semibold">{{ __('Please correct the highlighted fields.') }}</p>
                        </div>
                    @endif

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-ink-900">{{ __('Your name') }} <span class="text-red-600" aria-hidden="true">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" maxlength="120" class="mt-2 {{ $inputClass }}" @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
                            @error('name')<p id="name-error" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="business_name" class="block text-sm font-semibold text-ink-900">{{ __('Business name') }}</label>
                            <input type="text" id="business_name" name="business_name" value="{{ old('business_name') }}" autocomplete="organization" maxlength="160" class="mt-2 {{ $inputClass }}" @error('business_name') aria-invalid="true" aria-describedby="business_name-error" @enderror>
                            @error('business_name')<p id="business_name-error" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-ink-900">{{ __('Phone') }} <span class="text-red-600" aria-hidden="true">*</span></label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required autocomplete="tel" inputmode="tel" placeholder="01XXXXXXXXX" maxlength="40" class="mt-2 {{ $inputClass }}" @error('phone') aria-invalid="true" aria-describedby="phone-error" @enderror>
                            @error('phone')<p id="phone-error" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold text-ink-900">{{ __('Email') }} <span class="text-red-600" aria-hidden="true">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" inputmode="email" maxlength="190" class="mt-2 {{ $inputClass }}" @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                            @error('email')<p id="email-error" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="service" class="block text-sm font-semibold text-ink-900">{{ __('What are you interested in?') }}</label>
                            <select id="service" name="service" class="mt-2 {{ $inputClass }}" @error('service') aria-invalid="true" @enderror>
                                <option value="">{{ __('Select an option') }}</option>
                                @foreach($serviceOptions as $value => $label)
                                    <option value="{{ $value }}" @selected(old('service', $preselected) === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('service')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="budget" class="block text-sm font-semibold text-ink-900">{{ __('Approximate budget') }}</label>
                            <select id="budget" name="budget" class="mt-2 {{ $inputClass }}" @error('budget') aria-invalid="true" @enderror>
                                <option value="">{{ __('Select a range') }}</option>
                                @foreach($budgetOptions as $value => $label)
                                    <option value="{{ $value }}" @selected(old('budget') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('budget')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="message" class="block text-sm font-semibold text-ink-900">{{ __('Tell us about your project') }} <span class="text-red-600" aria-hidden="true">*</span></label>
                            <textarea id="message" name="message" rows="6" required minlength="20" maxlength="5000" placeholder="{{ __('What does your business do, what problem do you want to solve, and is there a timeline?') }}" class="mt-2 {{ $inputClass }}" @error('message') aria-invalid="true" aria-describedby="message-error" @enderror>{{ old('message') }}</textarea>
                            @error('message')<p id="message-error" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="flex items-start gap-3 text-sm text-ink-700">
                                <input type="checkbox" name="consent" value="1" @checked(old('consent')) required class="mt-1 h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-600">
                                <span>{!! __('I agree that :name may contact me about this enquiry. See our :privacy. :star', [
                                    'name' => e(Site::name()),
                                    'privacy' => '<a href="'.e(route('privacy')).'" class="font-medium text-brand-700 underline underline-offset-4">'.e(__('privacy policy')).'</a>',
                                    'star' => '<span class="text-red-600" aria-hidden="true">*</span>',
                                ]) !!}</span>
                            </label>
                            @error('consent')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <x-ui.button type="submit" size="lg" class="w-full sm:w-auto">{{ __('Send Message') }} <x-ui.icon name="arrow-right" class="h-4 w-4" /></x-ui.button>
                        <p class="text-xs text-ink-500">{{ __('Your details are used only to respond to your enquiry.') }}</p>
                    </div>
                </form>
                @endif
            </div>

            <aside class="lg:col-span-5">
                <div class="space-y-6">
                    <div class="rounded-2xl border border-ink-200 bg-white p-6 shadow-card">
                        <h2 class="text-lg font-semibold text-ink-900">{{ __('Other ways to reach us') }}</h2>
                        <ul class="mt-5 space-y-4 text-sm" role="list">
                            @if(Site::whatsappUrl())
                                <li class="flex gap-3">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#25D366]/10 text-[#128C7E]"><x-ui.icon name="whatsapp" class="h-5 w-5" /></span>
                                    <div><p class="font-semibold text-ink-900">WhatsApp</p><a href="{{ Site::whatsappUrl() }}" target="_blank" rel="noopener" class="text-brand-700 underline underline-offset-4">{{ __('Start a chat') }}</a></div>
                                </li>
                            @endif
                            @if(Site::phone())
                                <li class="flex gap-3">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-600"><x-ui.icon name="phone" class="h-5 w-5" /></span>
                                    <div><p class="font-semibold text-ink-900">{{ __('Phone') }}</p><a href="{{ Site::phoneHref() }}" class="text-brand-700 underline underline-offset-4">{{ Site::phone() }}</a></div>
                                </li>
                            @endif
                            @if(Site::email())
                                <li class="flex gap-3">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-600"><x-ui.icon name="mail" class="h-5 w-5" /></span>
                                    <div><p class="font-semibold text-ink-900">{{ __('Email') }}</p><a href="mailto:{{ Site::email() }}" class="text-brand-700 underline underline-offset-4">{{ Site::email() }}</a></div>
                                </li>
                            @endif
                            <li class="flex gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-600"><x-ui.icon name="map-pin" class="h-5 w-5" /></span>
                                <div>
                                    <p class="font-semibold text-ink-900">{{ __('Location') }}</p>
                                    <p class="text-ink-600">
                                        @if(Site::hasStreetAddress()){{ Site::address()['street'] }}, @endif{{ Site::address()['city'] ?? 'Dhaka' }}, {{ __('Bangladesh') }}
                                    </p>
                                    <p class="mt-1 text-xs text-ink-500">{{ __('In-person meetings in Dhaka by appointment; online meetings for everyone else.') }}</p>
                                </div>
                            </li>
                            @if(Site::hours())
                                <li class="flex gap-3">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-600"><x-ui.icon name="clock" class="h-5 w-5" /></span>
                                    <div><p class="font-semibold text-ink-900">{{ __('Business hours') }}</p><p class="text-ink-600">{{ Site::hours() }}</p></div>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <div class="rounded-2xl border border-ink-200 bg-ink-50/70 p-6">
                        <h2 class="text-base font-semibold text-ink-900">{{ __('What happens next') }}</h2>
                        <ol class="mt-4 space-y-3 text-sm text-ink-700" role="list">
                            <li class="flex gap-3"><span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-brand-600 text-xs font-bold text-white">1</span> {{ __('We read your message and reply within one business day.') }}</li>
                            <li class="flex gap-3"><span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-brand-600 text-xs font-bold text-white">2</span> {{ __('A short call or meeting to understand your business and goals.') }}</li>
                            <li class="flex gap-3"><span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-brand-600 text-xs font-bold text-white">3</span> {{ __('A written proposal or demo — no obligation.') }}</li>
                        </ol>
                    </div>

                    @if($faqs->isNotEmpty())
                        <div>
                            <h2 class="text-base font-semibold text-ink-900">{{ __('Pricing questions') }}</h2>
                            <x-ui.faq-list :faqs="$faqs" class="mt-3" />
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    </section>
</x-layouts.app>
