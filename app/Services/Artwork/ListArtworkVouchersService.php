<?php

namespace App\Services\Artwork;

use App\Models\Order;
use App\Services\Report\FetchIndividualReportByDate;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ListArtworkVouchersService
{
    use SelfCallingService;

    /** @var \App\Models\Order */
    private $orders;

    /**
     * Construct a new ListArtworkVouchersService
     *
     * @param  \App\Models\Order  $orders
     */
    public function __construct(Order $orders)
    {
        $this->orders = $orders;
    }

    /**
     * Handle the call to the service.
     */
    public function run(): array
    {
        if ($date = $this->orders->mostRecentReportCreatedDate()) {
            return  [
                'report' => FetchIndividualReportByDate::call('prototype', $date),
                'date' => $date,
                'timestamp' => to_timestamp($date),
            ];
        }

        return [];
    }
}
