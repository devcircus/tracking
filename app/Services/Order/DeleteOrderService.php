<?php

namespace App\Services\Order;

use App\Models\Order;
use PerfectOblivion\Services\Traits\SelfCallingService;

class DeleteOrderService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Order  $order
     */
    public function run(Order $order): Order
    {
        $deleted = $order->deleteOrder();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($deleted)
            ->withProperties(['target' => "{$deleted->order_number}-{$deleted->voucher}"])
            ->log('voucher deleted');

        return $deleted;
    }
}
