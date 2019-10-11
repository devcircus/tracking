<?php

namespace App\Services\Order;

use App\Models\Order;
use PerfectOblivion\Services\Traits\SelfCallingService;

class CompleteOrderService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Order  $order
     */
    public function run(Order $order): Order
    {
        $completed = $order->markAsComplete();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($completed)
            ->withProperties(['target' => "{$completed->order_number}-{$completed->voucher}"])
            ->log('voucher marked complete');

        return $completed;
    }
}
