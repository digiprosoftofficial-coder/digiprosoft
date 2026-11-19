<?php

declare(strict_types=1);

namespace App\Support\Content;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Versioned cache for relatively static public content (navigation,
 * featured items, FAQ groups...). Works with cache stores that do not
 * support tags: flushing simply bumps the version key so every previously
 * cached entry becomes unreachable and expires naturally.
 *
 * Only scalars/arrays are ever written to the cache. Laravel 13 refuses to
 * unserialize objects from cache storage by default (see
 * config/cache.php `serializable_classes`) and we keep that hardening.
 * Eloquent results are therefore cached as ordered primary-key lists and
 * re-hydrated with a single indexed `WHERE id IN (...)` query.
 */
final class ContentCache
{
    private const VERSION_KEY = 'content:version';

    private static ?int $version = null;

    /**
     * Cache a scalar or array value.
     */
    public static function remember(string $key, Closure $callback, ?int $ttl = null): mixed
    {
        $ttl ??= (int) config('site.cache_ttl', 3600);

        return Cache::remember(self::key($key), $ttl, $callback);
    }

    /**
     * Cache an Eloquent query result as an ordered list of primary keys and
     * hydrate it (with the query's eager loads) on every read.
     *
     * @template TModel of Model
     *
     * @param  Builder<TModel>  $query
     * @return EloquentCollection<int, TModel>
     */
    public static function rememberModels(string $key, Builder $query, ?int $ttl = null): EloquentCollection
    {
        $model = $query->getModel();

        /** @var list<int|string> $ids */
        $ids = self::remember($key, fn () => $query->pluck($model->getQualifiedKeyName())->all(), $ttl);

        if ($ids === []) {
            return $model->newCollection();
        }

        $positions = array_flip($ids);

        return $model->newQuery()
            ->with($query->getEagerLoads())
            ->findMany($ids)
            ->sortBy(fn (Model $m) => $positions[$m->getKey()] ?? PHP_INT_MAX)
            ->values();
    }

    /**
     * Cache the first result of an Eloquent query.
     *
     * @template TModel of Model
     *
     * @param  Builder<TModel>  $query
     * @return TModel|null
     */
    public static function rememberModel(string $key, Builder $query, ?int $ttl = null): ?Model
    {
        return self::rememberModels($key, $query->limit(1), $ttl)->first();
    }

    public static function flush(): void
    {
        self::$version = self::version() + 1;
        Cache::forever(self::VERSION_KEY, self::$version);
    }

    public static function key(string $key): string
    {
        return sprintf('content:v%d:%s', self::version(), $key);
    }

    private static function version(): int
    {
        return self::$version ??= (int) Cache::get(self::VERSION_KEY, 1);
    }
}
