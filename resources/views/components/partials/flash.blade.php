@if(session('status') || session('error'))
    @php
        $isError = (bool) session('error');
        $message = session('error') ?? session('status');
    @endphp
    <div class="container-site pt-6" data-dismissible>
        <div role="{{ $isError ? 'alert' : 'status' }}" aria-live="polite"
             class="flex items-start gap-3 rounded-lg border px-4 py-3 text-sm {{ $isError ? 'border-red-200 bg-red-50 text-red-800' : 'border-accent-500/30 bg-emerald-50 text-emerald-900' }}">
            <x-ui.icon :name="$isError ? 'alert' : 'check-circle'" class="mt-0.5 h-5 w-5 shrink-0" />
            <p class="flex-1">{{ $message }}</p>
            <button type="button" data-dismiss class="-m-1 rounded p-1 hover:bg-black/5" aria-label="Dismiss message">
                <x-ui.icon name="x" class="h-4 w-4" />
            </button>
        </div>
    </div>
@endif
