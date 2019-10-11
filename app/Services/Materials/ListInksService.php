<?php

namespace App\Services\Materials;

use App\Models\Ink;
use App\Services\Cache\CacheForeverService;
use Illuminate\Database\Eloquent\Collection;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ListInksService
{
    use SelfCallingService;

    /** @var \App\Models\Ink */
    private $inks;

    /**
     * Construct a new ListInksService.
     *
     * @param  \App\Models\Ink  $inks
     */
    public function __construct(Ink $inks)
    {
        $this->inks = $inks;
    }

    /**
     * Handle the call to the service.
     *
     * @param  bool  $withTrashed
     */
    public function run(bool $withTrashed = true): Collection
    {
        return CacheForeverService::call('inks', function() use ($withTrashed) {
            return $this->inks->withTrashed($withTrashed)->get();
        });
    }
}
