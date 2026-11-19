<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function __invoke(): Response
    {
        $lines = app()->environment('production')
            ? [
                'User-agent: *',
                'Allow: /',
                'Disallow: /admin',
                'Disallow: /dashboard',
                'Disallow: /login',
                'Disallow: /register',
                'Disallow: /private',
                'Disallow: /up',
                '',
                '# AI / LLM crawlers: see /llms.txt for a concise site summary.',
                'Sitemap: '.route('sitemap'),
            ]
            : [
                '# Non-production environment: keep out of search engines.',
                'User-agent: *',
                'Disallow: /',
            ];

        return response(implode("\n", $lines)."\n", 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
