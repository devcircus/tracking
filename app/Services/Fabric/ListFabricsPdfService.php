<?php

namespace App\Services\Fabric;

use App\Models\Fabric;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Materials\ListFabricsService;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ListFabricsPdfService
{
    use SelfCallingService;

    /** @var \App\Models\Fabric */
    private $fabrics;

    /**
     * Construct a new ListFabricsPdfService.
     *
     * @param  \App\Models\Fabric  $fabrics
     */
    public function __construct(Fabric $fabrics)
    {
        $this->fabrics = $fabrics;
    }

    /**
     * Handle the call to the service.
     */
    public function run(): Collection
    {
        return ListFabricsService::call();
    }
}
