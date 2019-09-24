<?php

namespace App\Services\Notifications;

use App\Models\User;
use App\Notifications\ArtComplete;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ArtworkCompleteNotificationService extends NotificationService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Order|\Illuminate\Support\Collection  $orders
     * @param  \App\Models\User  $user
     */
    public function run($orders, User $user): void
    {
        $this->send($this->users->superAdministrator(), new ArtComplete($orders, $user));
    }
}
