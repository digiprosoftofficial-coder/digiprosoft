<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Collapses duplicate URL variants with a single 301:
 *  - trailing slashes   (/about/  -> /about)
 *  - upper-case paths   (/About   -> /about)
 *  - non-canonical host/scheme in production when enabled
 *    (http://digiprosoft.com -> https://www.digiprosoft.com)
 */
class RedirectToCanonicalUrl
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isMethod('GET') && ! $request->isMethod('HEAD')) {
            return $next($request);
        }

        $path = $request->getPathInfo();
        $target = null;

        if ($path !== '/' && str_ends_with($path, '/')) {
            $target = rtrim($path, '/');
        }

        $candidate = $target ?? $path;
        if ($candidate !== strtolower($candidate) && ! str_starts_with($candidate, '/build/') && ! str_starts_with($candidate, '/storage/')) {
            $target = strtolower($candidate);
        }

        $scheme = $request->getScheme();
        $host = $request->getHost();

        if (config('site.force_canonical_host') && app()->environment('production')) {
            $canonical = parse_url((string) config('site.url'));
            $wantScheme = $canonical['scheme'] ?? 'https';
            $wantHost = $canonical['host'] ?? $host;

            if ($host !== $wantHost || $scheme !== $wantScheme) {
                $target ??= $path;
                $scheme = $wantScheme;
                $host = $wantHost;
            }
        }

        if ($target === null) {
            return $next($request);
        }

        $query = $request->getQueryString();
        $url = $scheme.'://'.$host.$target.($query ? '?'.$query : '');

        return redirect()->to($url, 301);
    }
}
