<?php

namespace App\Services\Materials;

use App\Models\Fabric;
use App\Services\Cache\CacheForeverService;
use Illuminate\Database\Eloquent\Collection;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ListFabricsService
{
    use SelfCallingService;

    /** @var \App\Models\Fabric */
    private $fabrics;

    /**
     * Construct a new ListFabricsService.
     *
     * @param  \App\Models\Fabric  $fabrics
     */
    public function __construct(Fabric $fabrics)
    {
        $this->fabrics = $fabrics;
    }

    /**
     * Handle the call to the service.
     *
     * @param  bool  $withTrashed
     */
    public function run(bool $withTrashed = true): Collection
    {
        return CacheForeverService::call('fabrics', function() use ($withTrashed) {
            return $this->fabrics->withTrashed($withTrashed)->get();
        });
    }
}
