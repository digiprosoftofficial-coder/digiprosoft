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
            'pharmacy-management-system' => 'Pharmacy Management System',
            'hotel-management-system' => 'Hotel Management System',
            'school-management-system' => 'School Management System',
            'pos-system' => 'POS System',
            'ecommerce-platform' => 'E-commerce Platform / Online Store',
            'custom-software-development' => 'Custom Software Development',
            'web-development' => 'Website Development',
            'business-automation' => 'Business Automation',
            'api-development' => 'API Development & Integration',
            'saas-development' => 'SaaS Product Development',
            'software-maintenance' => 'Software Maintenance & Support',
            'other' => 'Something else / not sure yet',
        ];
    }

    /** @return array<string, string> */
    public static function budgetOptions(): array
    {
        return [
            'undecided' => 'Not decided yet',
            'under-50k' => 'Under ৳50,000',
            '50k-150k' => '৳50,000 – ৳1,50,000',
            '150k-500k' => '৳1,50,000 – ৳5,00,000',
            '500k-plus' => 'Above ৳5,00,000',
        ];
    }
}
