@php $gaId = \App\Support\Site::analyticsId(); @endphp
@if($gaId && app()->environment('production'))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}" nonce="{{ \Illuminate\Support\Facades\Vite::cspNonce() }}"></script>
<script nonce="{{ \Illuminate\Support\Facades\Vite::cspNonce() }}">
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', @json($gaId), { anonymize_ip: true });
</script>
@endif
