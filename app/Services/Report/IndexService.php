<?php

namespace App\Services\Report;

use App\Services\Dashboard\BuildDashboardData;
use PerfectOblivion\Services\Traits\SelfCallingService;

class IndexService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @return mixed
     */
    public function run()
    {
        return BuildDashboardData::call();
    }
}
