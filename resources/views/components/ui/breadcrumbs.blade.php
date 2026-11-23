@props(['items' => [], 'light' => false])
@if(count($items) > 1)
<nav aria-label="{{ __('Breadcrumb') }}" {{ $attributes->merge(['class' => 'text-sm']) }}>
    <ol class="flex flex-wrap items-center gap-x-1.5 gap-y-1 {{ $light ? 'text-ink-300' : 'text-ink-500' }}" role="list">
        @foreach($items as $item)
            <li class="flex items-center gap-1.5">
                @if(!$loop->last)
                    <a href="{{ $item['url'] }}" class="rounded hover:underline underline-offset-4 {{ $light ? 'hover:text-white' : 'hover:text-ink-900' }}">{{ $item['name'] }}</a>
                    <x-ui.icon name="chevron-right" class="h-3.5 w-3.5 opacity-60" />
                @else
                    <span aria-current="page" class="font-medium {{ $light ? 'text-white' : 'text-ink-900' }}">{{ $item['name'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
@endif
