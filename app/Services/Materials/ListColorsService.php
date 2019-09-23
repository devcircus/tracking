<?php

namespace App\Services\Materials;

use App\Models\Color;
use App\Services\Cache\CacheForeverService;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ListColorsService
{
    use SelfCallingService;

    /** @var \App\Models\Color */
    private $colors;

    /**
     * Construct a new ListColorsService.
     *
     * @param  \App\Models\Color  $colors
     */
    public function __construct(Color $colors)
    {
        $this->colors = $colors;
    }

    /**
     * Handle the call to the service.
     *
     * @param  bool  $withTrashed
     *
     * @return mixed
     */
    public function run(bool $withTrashed = true)
    {
        return CacheForeverService::call('colors', function() use ($withTrashed) {
            return $this->colors->withTrashed($withTrashed)->get();
        });
    }
}
