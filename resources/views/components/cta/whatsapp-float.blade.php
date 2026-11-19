@php $wa = \App\Support\Site::whatsappUrl(); @endphp
@if($wa)
    <a href="{{ $wa }}" target="_blank" rel="noopener"
       class="fixed bottom-5 right-5 z-40 flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-elevated transition-transform hover:scale-105 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#25D366] motion-reduce:transition-none print:hidden"
       aria-label="Chat with {{ \App\Support\Site::name() }} on WhatsApp">
        <x-ui.icon name="whatsapp" class="h-7 w-7" />
    </a>
@endif
