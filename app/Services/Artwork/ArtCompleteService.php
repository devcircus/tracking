<?php

namespace App\Services\Artwork;

use App\Models\User;
use App\Models\Order;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ArtCompleteService
{
    use SelfCallingService;

    /** @var \App\Models\User */
    private $users;

    /**
     * Construct a new ArtCompleteService.
     *
     * @param  \App\Models\User  $users
     */
    public function __construct(User $users)
    {
        $this->users = $users;
    }

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
