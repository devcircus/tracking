<?php

namespace App\Services\Cache;

use Closure;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Get the cache key.
     *
     * @param  string  $prefix
     * @param  string  $suffix
     */
    protected function getCacheKey(string $prefix, string $suffix): string
    {
        $hashed = md5($suffix);

        return "{$prefix}-{$hashed}";
    }

    /**
     * Cache the result of the callable forever.
     *
     * @param  string  $key
     * @param  \Closure  $callback
     *
     * @return mixed
     */
    protected function forever(string $key, Closure $callback)
    {
        return Cache::rememberForever($key, $callback);
    }

    /**
     * Forget a cache entry for the given key.
     *
     * @param  string  $key
     */
    protected function forget(string $key): bool
    {
        return Cache::forget($key);
    }
}
