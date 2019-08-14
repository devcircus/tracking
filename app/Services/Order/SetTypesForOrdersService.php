<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Services\OrderTypes\SetOrderTypes;
use PerfectOblivion\Services\Traits\SelfCallingService;

class SetTypesForOrdersService
{
    use SelfCallingService;

    /** @var \App\Models\Order */
    private $orders;

    /**
     * Construct a new SetTypesForOrdersService.
     *
     * @param  \App\Models\Order  $orders
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
    public function run(string $date): void
    {
        $orders = $this->orders->forDate($date)->get();

        foreach ($orders as $order) {
            SetOrderTypes::call($order);
        }
    }
}
