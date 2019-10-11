<?php

namespace App\Services\Report;

use App\Services\Dashboard\BuildDashboardData;
use PerfectOblivion\Services\Traits\SelfCallingService;

class IndexService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     */
    public function run(): array
    {
        return BuildDashboardData::call();
    }
}
