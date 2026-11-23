<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var list<string> $supported */
        $supported = config('localization.supported', ['en', 'bn']);
        $sessionKey = (string) config('localization.session_key', 'locale');
        $cookieName = (string) config('localization.cookie', 'locale');

        $candidate = $request->session()->get($sessionKey)
            ?? $request->cookie($cookieName)
            ?? config('app.locale', 'en');

        $locale = is_string($candidate) && in_array($candidate, $supported, true)
            ? $candidate
            : (string) ($supported[0] ?? 'en');

        App::setLocale($locale);

        return $next($request);
    }
}
