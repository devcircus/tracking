<?php

namespace App\Services\Cache;

use Closure;
use PerfectOblivion\Services\Traits\SelfCallingService;

class CacheForeverService extends CacheService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  string  $prefix
     * @param  string  $rawSuffix
     *
     * @return mixed
     */
    public function run(string $prefix, string $rawSuffix, Closure $callback)
    {
        return $this->forever($this->getCacheKey($prefix, $rawSuffix), $callback);
    }
}
