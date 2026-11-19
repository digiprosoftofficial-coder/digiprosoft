<?php

declare(strict_types=1);

namespace App\Support\Content;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

/**
 * Rendering helpers for stored content.
 *
 * - markdown(): for short fields (FAQ answers, problem/solution blurbs).
 *   Raw HTML is stripped, so links/emphasis must be written as Markdown.
 * - html(): for long-form editorial content authored in HTML by the team.
 *   Only use this for trusted, admin-authored content.
 */
final class RichText
{
    public static function markdown(?string $text): HtmlString
    {
        if ($text === null || trim($text) === '') {
            return new HtmlString('');
        }

        return new HtmlString(Str::markdown($text, [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]));
    }

    public static function html(?string $html): HtmlString
    {
        return new HtmlString($html ?? '');
    }

    public static function paragraphs(?string $text): HtmlString
    {
        return self::markdown($text);
    }
}
