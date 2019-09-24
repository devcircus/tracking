<?php

namespace App\Services\Notifications;

use App\Models\InventoryItem;
use App\Notifications\MinimumInventoryReached;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ReorderNotificationService extends NotificationService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\InventoryItem  $item
     */
    public function run(InventoryItem $item): void
    {
        $this->send($this->users->getAdmins(), new MinimumInventoryReached($item));
    }
}
