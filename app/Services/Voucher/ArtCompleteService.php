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
        $complete = $order->toggleArtComplete();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($order)
            ->withProperties(['target' => "{$order->order_number}-{$order->voucher}"])
            ->log($complete ? 'art complete' : 'art not complete');

        return $complete;
    }
}
