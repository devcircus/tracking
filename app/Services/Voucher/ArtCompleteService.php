<?php

namespace App\Services\Voucher;

use App\Models\Order;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ArtCompleteService
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
        return $order->toggleArtComplete();
    }
}
