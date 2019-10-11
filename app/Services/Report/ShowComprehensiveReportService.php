<?php

namespace App\Services\Report;

use App\Services\Summary\FetchSummaryByDate;
use App\Services\Report\FetchAllOrdersByDate;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ShowComprehensiveReportService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  string  $date
     */
    public function run(string $date): array
    {
        return [
            'reports' => FetchAllOrdersByDate::call($date),
            'summary' => FetchSummaryByDate::call($date)
        ];
    }
}
