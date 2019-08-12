<?php

namespace App\Services\Summary;

use App\Services\Summary\FetchSummaryByDate;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ShowSummaryService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @return mixed
     */
    public function run(array $params)
    {
        return FetchSummaryByDate::call($params['date']);
    }
}
