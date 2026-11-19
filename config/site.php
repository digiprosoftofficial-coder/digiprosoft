<?php

/*
|--------------------------------------------------------------------------
| DigiProSoft Site Settings
|--------------------------------------------------------------------------
|
| Centralised, environment-driven company/brand settings. Nothing in the
| Blade templates should hard-code these values. Only verified information
| belongs here; leave unknown values empty and the UI will hide them.
|
*/

return [

    'name' => env('SITE_NAME', 'DigiProSoft'),
    'legal_name' => env('SITE_LEGAL_NAME', 'DigiProSoft'),
    'tagline' => env('SITE_TAGLINE', 'Digital Product & Software Solution'),
    'url' => rtrim(env('APP_URL', 'https://www.digiprosoft.com'), '/'),

    /*
    | Canonical host handling. When enabled in production, requests for any
    | other host/scheme are 301-redirected to the canonical APP_URL.
    */
    'force_canonical_host' => (bool) env('SITE_FORCE_CANONICAL_HOST', false),

    'contact' => [
        'email' => env('SITE_EMAIL', ''),
        'phone' => env('SITE_PHONE', ''),
        // International format without "+" or spaces, e.g. 8801XXXXXXXXX
        'whatsapp' => env('SITE_WHATSAPP', ''),
        'whatsapp_message' => env('SITE_WHATSAPP_MESSAGE', 'Hello DigiProSoft, I would like to discuss a software project.'),
        'address' => [
            'street' => env('SITE_ADDRESS_STREET', ''),
            'city' => env('SITE_ADDRESS_CITY', 'Dhaka'),
            'region' => env('SITE_ADDRESS_REGION', 'Dhaka Division'),
            'postal_code' => env('SITE_ADDRESS_POSTAL_CODE', ''),
            'country' => env('SITE_ADDRESS_COUNTRY', 'BD'),
        ],
        // Leave empty to hide. Example: "Saturday – Thursday, 10:00 AM – 7:00 PM (GMT+6)"
        'hours' => env('SITE_BUSINESS_HOURS', ''),
        // Where contact form notifications are delivered. Falls back to contact.email.
        'inquiry_recipient' => env('SITE_INQUIRY_RECIPIENT', env('SITE_EMAIL', '')),
    ],

    'social' => [
        'facebook' => env('SOCIAL_FACEBOOK', ''),
        'linkedin' => env('SOCIAL_LINKEDIN', ''),
        'youtube' => env('SOCIAL_YOUTUBE', ''),
        'x' => env('SOCIAL_X', ''),
        'github' => env('SOCIAL_GITHUB', ''),
    ],

    'seo' => [
        'default_title' => env('SEO_DEFAULT_TITLE', 'DigiProSoft | Digital Product & Software Solution'),
        'title_suffix' => env('SEO_TITLE_SUFFIX', ' | DigiProSoft'),
        'default_description' => env(
            'SEO_DEFAULT_DESCRIPTION',
            'DigiProSoft builds business management software, websites, e-commerce platforms, SaaS products and custom software for businesses in Bangladesh and beyond.'
        ),
        'default_og_image' => env('SEO_DEFAULT_OG_IMAGE', '/images/og/digiprosoft-og.png'),
        'twitter_handle' => env('SEO_TWITTER_HANDLE', ''),
        'locale' => 'en_US',
    ],

    'analytics' => [
        'google_analytics_id' => env('GOOGLE_ANALYTICS_ID', ''),
        'google_site_verification' => env('GOOGLE_SITE_VERIFICATION', ''),
        'bing_site_verification' => env('BING_SITE_VERIFICATION', ''),
    ],

    'branding' => [
        'logo' => '/images/brand/digiprosoft-logo.png',
        'logo_dark' => '/images/brand/digiprosoft-logo-dark.png',
        'mark' => '/images/brand/digiprosoft-mark.png',
        'theme_color' => '#0c205a',
    ],

    'cache_ttl' => (int) env('SITE_CACHE_TTL', 3600),

];
