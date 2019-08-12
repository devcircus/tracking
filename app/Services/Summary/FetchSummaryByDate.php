<?php

namespace App\Services\Summary;

use App\Models\Order;
use App\Services\CachedService;
use PerfectOblivion\Services\Traits\SelfCallingService;

class FetchSummaryByDate extends CachedService
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
     * @param  string  $date
     *
     * @return \Illuminate\Support\Collection
     */
    public function run(string $date)
    {
        return resolve('orders')->only(['prototype', 'production'])->map(function ($type) use ($date) {
            $query = $this->orders->type($type)->forDate($date)->notComplete($type);

            return [
                'summary' => $query->weeklyVouchers(),
                'total' => $query->count(),
            ];
        });
    }
}
