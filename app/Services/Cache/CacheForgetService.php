<?php

namespace App\Services\Cache;

use PerfectOblivion\Services\Traits\SelfCallingService;

class CacheForgetService extends CacheService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  string  $prefix
     * @param  string  $rawSuffix
     */
    public function run(string $prefix, string $rawSuffix): bool
    {
        return $this->forget($this->getCacheKey($prefix, $rawSuffix));
    }
}
