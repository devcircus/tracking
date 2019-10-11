<?php

namespace App\Services\Report;

use Illuminate\Support\Collection;
use App\Services\Report\FetchIndividualReportByDate;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ShowIndividualReportService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  array  $params
     */
    public function run(array $params): Collection
    {
        return FetchIndividualReportByDate::call($params['type'], $params['date']);
    }
}
