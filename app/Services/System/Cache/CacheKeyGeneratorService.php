<?php

namespace App\Services\System\Cache;

use Illuminate\Support\Arr;
use PerfectOblivion\Services\Traits\SelfCallingService;

class CacheKeyGeneratorService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  string  $type
     * @param  mixed  $base
     *
     * @return string
     */
    public function run(string $type, $base)
    {
        return $type.':'.$this->getHash($base);
    }

    /**
     * Get hashed version of the key pieces.
     *
     * @param  mixed  $pieces
     *
     * @return string
     */
    private function getHash($pieces)
    {
        $hashed = array_map(function ($piece) {
            return md5($piece);
        }, Arr::wrap($pieces));

        return implode(':', $hashed);
    }
}
