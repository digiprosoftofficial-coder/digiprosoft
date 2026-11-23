<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LocaleController extends Controller
{
    public function __invoke(Request $request, string $locale): RedirectResponse
    {
        /** @var list<string> $supported */
        $supported = config('localization.supported', ['en', 'bn']);

        abort_unless(in_array($locale, $supported, true), 404);

        $sessionKey = (string) config('localization.session_key', 'locale');
        $cookieName = (string) config('localization.cookie', 'locale');

        $request->session()->put($sessionKey, $locale);

        $fallback = route('home');
        $previous = url()->previous();
        $target = ($previous !== '' && $previous !== $request->fullUrl() && str_starts_with($previous, $request->root()))
            ? $previous
            : $fallback;

        return redirect()
            ->to($target)
            ->withCookie(Cookie::forever($cookieName, $locale, null, null, null, true, false, 'lax'));
    }
}
