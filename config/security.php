<?php

return [

    'hsts' => [
        'enabled' => (bool) env('SECURITY_HSTS_ENABLED', true),
        'max_age' => 31536000,
        'preload' => false,
    ],

    /*
    | Content Security Policy. Scripts require the per-request nonce; add
    | third-party origins here rather than loosening the policy globally.
    */
    'csp' => [
        'enabled' => (bool) env('SECURITY_CSP_ENABLED', true),
        'sources' => [
            'script' => ['https://www.googletagmanager.com'],
            'style' => [],
            'img' => ['https://www.googletagmanager.com', 'https://*.google-analytics.com'],
            'font' => [],
            'connect' => ['https://*.google-analytics.com', 'https://*.analytics.google.com', 'https://www.googletagmanager.com'],
            'frame' => ["'none'"],
        ],
    ],

];
