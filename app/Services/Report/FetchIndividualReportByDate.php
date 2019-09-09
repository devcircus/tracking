<?php

namespace App\Services\Report;

use App\Models\Order;
use PerfectOblivion\Services\Traits\SelfCallingService;

class FetchIndividualReportByDate
{
    use SelfCallingService;

    /** @var \App\Models\Order */
    private $orders;

    /**
     * Construct a new FetchAllOrdersByDate service.
     *
     * @param  \App\Models\Order  $orders
     */
    public function __construct(Order $orders)
    {
        $this->orders = $orders;
    }

    /**
     * Handle fetching all reports by the given date.
     *
     * @param  string  $type
     * @param  string  $date
     *
     * @return \Illuminate\Support\Collection
     */
    public function run(string $type, string $date)
    {
        return $this->orders->with('types')->type($type)->notComplete()->forDate($date)->get();
    }
}
