<?php

namespace App\Services\Materials;

use App\Models\Fabric;
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
     *
     * @return mixed
     */
    public function run(bool $withTrashed = true): Collection
    {
        return $this->fabrics->withTrashed($withTrashed)->get();
    }
}
