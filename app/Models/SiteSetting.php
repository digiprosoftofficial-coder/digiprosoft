<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\Content\ContentCache;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    /** @var list<string> */
    public const NETWORKS = ['facebook', 'instagram', 'linkedin', 'youtube', 'x', 'github'];

    protected $fillable = [
        'facebook',
        'instagram',
        'linkedin',
        'youtube',
        'x',
        'github',
        'twitter_handle',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => ContentCache::flush());
        static::deleted(fn () => ContentCache::flush());
    }

    public static function current(): self
    {
        return static::query()->first() ?? new self;
    }

    /**
     * @return array<string, string>
     */
    public function socialUrls(): array
    {
        $urls = [];

        foreach (self::NETWORKS as $network) {
            $value = $this->{$network};

            if (is_string($value) && $value !== '') {
                $urls[$network] = $value;
            }
        }

        return $urls;
    }
}
