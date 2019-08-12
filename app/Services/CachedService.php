<?php

namespace App\Services;

use App\Services\System\Cache\CacheKeyGeneratorService;

abstract class CachedService
{
    /**
     * Get the cache key for the class.
     *
     * @param  string  $type
     * @param  mixed  $base
     *
     * @return string
     */
    protected function cacheKey(string $type, $base)
    {
        return CacheKeyGeneratorService::call($type, $base);
    }
}
