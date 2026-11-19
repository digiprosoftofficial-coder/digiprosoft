<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;
use Symfony\Component\HttpFoundation\Response;

/**
 * Baseline hardening headers for every response. The CSP uses a per-request
 * nonce (shared with Vite and the analytics snippet) instead of 'unsafe-inline'
 * for scripts. Adjust config/security.php when adding third-party embeds.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $nonce = Vite::useCspNonce();

        /** @var Response $response */
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=(), usb=(), interest-cohort=()');
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');

        if (config('security.hsts.enabled') && $request->isSecure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age='.(int) config('security.hsts.max_age').'; includeSubDomains'.(config('security.hsts.preload') ? '; preload' : '')
            );
        }

        if (config('security.csp.enabled') && ! $request->is('admin', 'admin/*', 'livewire/*')) {
            $response->headers->set('Content-Security-Policy', $this->contentSecurityPolicy($nonce));
        }

        return $response;
    }

    private function contentSecurityPolicy(string $nonce): string
    {
        $extra = config('security.csp.sources', []);
        $isHot = app()->environment('local') && file_exists(public_path('hot'));
        $dev = $isHot ? ['http://localhost:5173', 'http://127.0.0.1:5173', 'ws://localhost:5173', 'ws://127.0.0.1:5173'] : [];

        $directives = [
            'default-src' => ["'self'"],
            'base-uri' => ["'self'"],
            'object-src' => ["'none'"],
            'frame-ancestors' => ["'self'"],
            'form-action' => ["'self'"],
            'script-src' => ["'self'", "'nonce-{$nonce}'", ...($extra['script'] ?? []), ...$dev],
            'style-src' => ["'self'", "'unsafe-inline'", ...($extra['style'] ?? []), ...$dev],
            'img-src' => ["'self'", 'data:', 'blob:', 'https:', ...($extra['img'] ?? [])],
            'font-src' => ["'self'", 'data:', ...($extra['font'] ?? []), ...$dev],
            'connect-src' => ["'self'", ...($extra['connect'] ?? []), ...$dev],
            'frame-src' => [...($extra['frame'] ?? ["'none'"])],
            'upgrade-insecure-requests' => [],
        ];

        if ($isHot || ! app()->environment('production')) {
            unset($directives['upgrade-insecure-requests']);
        }

        return collect($directives)
            ->map(fn (array $sources, string $name) => trim($name.' '.implode(' ', array_unique($sources))))
            ->implode('; ');
    }
}
