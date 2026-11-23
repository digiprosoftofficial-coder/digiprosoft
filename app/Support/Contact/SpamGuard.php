<?php

declare(strict_types=1);

namespace App\Support\Contact;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

/**
 * Lightweight, privacy-friendly anti-spam for the contact form:
 *  - a honeypot field that humans never see or fill,
 *  - an encrypted server timestamp that must be at least N seconds old
 *    (bots submit instantly) and not older than a few hours (replay),
 *  - a simple link-count heuristic.
 *
 * No third-party CAPTCHA is required, so nothing is sent to external services.
 */
final class SpamGuard
{
    public const HONEYPOT_FIELD = 'company_website';

    public const TIMESTAMP_FIELD = '_form_token';

    public const MIN_SECONDS = 3;

    public const MAX_SECONDS = 6 * 60 * 60;

    public static function token(): string
    {
        return Crypt::encryptString((string) now()->timestamp);
    }

    public static function isTimestampValid(string $token): bool
    {
        if ($token === '') {
            return false;
        }

        try {
            $issued = (int) Crypt::decryptString($token);
        } catch (DecryptException) {
            return false;
        }

        $age = now()->timestamp - $issued;

        return $age >= self::MIN_SECONDS && $age <= self::MAX_SECONDS;
    }

    public static function looksLikeSpam(string $message): bool
    {
        $links = preg_match_all('#https?://|www\.#i', $message);

        return $links >= 3;
    }

    /** @return array<string, string> */
    public static function serviceOptions(): array
    {
        return [
            'pharmacy-management-system' => __('Pharmacy Management System'),
            'hotel-management-system' => __('Hotel Management System'),
            'school-management-system' => __('School Management System'),
            'pos-system' => __('POS System'),
            'ecommerce-platform' => __('E-commerce Platform / Online Store'),
            'custom-software-development' => __('Custom Software Development'),
            'web-development' => __('Website Development'),
            'business-automation' => __('Business Automation'),
            'api-development' => __('API Development & Integration'),
            'saas-development' => __('SaaS Product Development'),
            'software-maintenance' => __('Software Maintenance & Support'),
            'other' => __('Something else / not sure yet'),
        ];
    }

    /** @return array<string, string> */
    public static function budgetOptions(): array
    {
        return [
            'undecided' => __('Not decided yet'),
            'under-50k' => __('Under ৳50,000'),
            '50k-150k' => __('৳50,000 – ৳1,50,000'),
            '150k-500k' => __('৳1,50,000 – ৳5,00,000'),
            '500k-plus' => __('Above ৳5,00,000'),
        ];
    }
}
