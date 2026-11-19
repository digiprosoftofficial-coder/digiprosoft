<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\SiteSetting;
use App\Support\Content\ContentCache;

/**
 * Typed accessor around config('site.*'). Keeps Blade templates free of
 * repeated config() calls and centralises formatting (tel: links, WhatsApp
 * deep links, absolute asset URLs).
 */
final class Site
{
    public static function name(): string
    {
        return (string) config('site.name');
    }

    public static function legalName(): string
    {
        return (string) config('site.legal_name');
    }

    public static function tagline(): string
    {
        return (string) config('site.tagline');
    }

    public static function url(string $path = ''): string
    {
        $base = rtrim((string) config('site.url'), '/');

        return $path === '' ? $base : $base.'/'.ltrim($path, '/');
    }

    public static function email(): ?string
    {
        return self::nullable(config('site.contact.email'));
    }

    public static function phone(): ?string
    {
        return self::nullable(config('site.contact.phone'));
    }

    public static function phoneHref(): ?string
    {
        $phone = self::phone();

        return $phone ? 'tel:'.preg_replace('/[^\d+]/', '', $phone) : null;
    }

    public static function whatsapp(): ?string
    {
        return self::nullable(config('site.contact.whatsapp'));
    }

    public static function whatsappUrl(?string $message = null): ?string
    {
        $number = self::whatsapp();
        if (! $number) {
            return null;
        }

        $number = preg_replace('/\D/', '', $number);
        $text = $message ?? (string) config('site.contact.whatsapp_message');

        return 'https://wa.me/'.$number.($text ? '?text='.rawurlencode($text) : '');
    }

    public static function hours(): ?string
    {
        return self::nullable(config('site.contact.hours'));
    }

    /** @return array<string, string> */
    public static function socials(): array
    {
        return ContentCache::remember('site.socials', function (): array {
            $settings = SiteSetting::query()->first();

            if ($settings instanceof SiteSetting) {
                return $settings->socialUrls();
            }

            return array_filter(
                (array) config('site.social', []),
                fn ($url) => is_string($url) && $url !== ''
            );
        });
    }

    public static function twitterHandle(): ?string
    {
        return ContentCache::remember('site.twitter_handle', function (): ?string {
            $settings = SiteSetting::query()->first();

            if ($settings instanceof SiteSetting) {
                return self::nullable($settings->twitter_handle);
            }

            return self::nullable(config('site.seo.twitter_handle'));
        });
    }

    /** @return array<string, string> */
    public static function address(): array
    {
        return array_filter((array) config('site.contact.address', []), fn ($v) => is_string($v) && $v !== '');
    }

    public static function hasStreetAddress(): bool
    {
        return self::nullable(config('site.contact.address.street')) !== null;
    }

    public static function logo(bool $dark = false): string
    {
        return (string) config($dark ? 'site.branding.logo_dark' : 'site.branding.logo');
    }

    public static function defaultOgImage(): string
    {
        return self::absolute((string) config('site.seo.default_og_image'));
    }

    public static function analyticsId(): ?string
    {
        return self::nullable(config('site.analytics.google_analytics_id'));
    }

    public static function googleVerification(): ?string
    {
        return self::nullable(config('site.analytics.google_site_verification'));
    }

    public static function bingVerification(): ?string
    {
        return self::nullable(config('site.analytics.bing_site_verification'));
    }

    /**
     * Turn a relative path into an absolute production URL.
     */
    public static function absolute(?string $path): string
    {
        if ($path === null || $path === '') {
            return self::url();
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        return self::url($path);
    }

    private static function nullable(mixed $value): ?string
    {
        return is_string($value) && trim($value) !== '' ? trim($value) : null;
    }
}
