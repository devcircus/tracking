<?php

namespace App\Services\Summary;

use Illuminate\Support\Collection;
use App\Services\Summary\FetchSummaryByDate;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ShowSummaryService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     */
    public function run(array $params): Collection
    {
        return FetchSummaryByDate::call($params['date']);
    }
}
