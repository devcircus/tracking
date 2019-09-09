<?php

namespace App\Services\Artwork;

use App\Models\User;
use App\Models\Order;
use App\Notifications\ArtComplete;
use Illuminate\Support\Facades\Notification;
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
        $authenticated = auth()->user();

        if ($complete) {
            Notification::send($this->users->administrators(), new ArtComplete($order, $authenticated));
        }

        activity()
            ->causedBy($authenticated)
            ->performedOn($order)
            ->withProperties(['target' => "{$order->order_number}-{$order->voucher}"])
            ->log($complete ? 'art complete' : 'art not complete');

        return $complete;
    }
}
