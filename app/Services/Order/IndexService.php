<?php

namespace App\Services\Order;

use App\Models\Upload;
use App\Services\Order\BuildDashboardData;
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
