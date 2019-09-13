<?php

namespace App\Services\Materials;

use App\Models\Fabric;
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
     * @return mixed
     */
    public function run()
    {
        return $this->fabrics->all();
    }
}
