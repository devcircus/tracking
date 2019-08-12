<?php

namespace App\Models\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

trait ClearsCache
{
    /**
     * Clear the cache for the given tag.
     *
     * @param  array|string  $tags
     */
    public function clearCacheForTags($tags)
    {
        return Cache::tags(Arr::wrap($tags))->flush();
    }

    /**
     * Clear the cache for the given key.
     *
     * @param  string  $key
     */
    public function clearCacheForKey(string $key)
    {
        return Cache::forget($key);
    }
}
