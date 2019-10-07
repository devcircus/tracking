<?php

namespace App\Services\Order;

use App\Models\Order;
use PerfectOblivion\Services\Traits\SelfCallingService;

class CopyManuallyAddedOrdersService
{
    use SelfCallingService;

    /** @var \App\Models\Order */
    private $orders;

    /**
     * Construct a new CopyManuallyAddedOrdersService.
     */
    public function __construct(Order $orders)
    {
        $this->orders = $orders;
    }

    /**
     * Handle the call to the service.
     *
     * @param  string  $date
     */
    public function run(string $date)
    {
        $previousReportCreatedDate = $this->orders->select('report_created')->where('report_created', '<', $date)->latest()->first()->report_created;

        $manuallyAddedOrders = $this->orders->notComplete()->where('report_created', $previousReportCreatedDate)->where('manually_added', true)->get();

        foreach ($manuallyAddedOrders as $order) {
            $this->orders->saveOrder(array_merge($order->toArray(), ['report_created' => $date]));
        }
    }
}
