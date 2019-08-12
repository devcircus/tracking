<?php

namespace App\Services\Report;

use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Report\FetchIndividualReportByDate;

class ShowIndividualReportService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  array  $params
     *
     * @return mixed
     */
    public function run(array $params)
    {
        return FetchIndividualReportByDate::call($params['type'], $params['date']);
    }
}
