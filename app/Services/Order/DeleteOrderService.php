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
     *
     * @return mixed
     */
    public function run(Order $order)
    {
        return $order->deleteOrder();
    }
}
