<?php

namespace App\Services\Notifications;

use App\Models\User;
use App\Models\InventoryItem;
use Illuminate\Support\Facades\Notification;
use App\Notifications\MinimumInventoryReached;
use PerfectOblivion\Services\Traits\SelfCallingService;

class SendReorderNotificationService
{
    use SelfCallingService;

    /** @var \App\Models\User */
    private $users;

    /**
     * Construct a new SendReorderNotificationService.
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
     * @param  \App\Models\InventoryItem  $item
     *
     * @return mixed
     */
    public function run(InventoryItem $item)
    {
        Notification::send($this->users->getAdmins(), new MinimumInventoryReached($item));
    }
}
