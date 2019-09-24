<?php

namespace App\Services\Notifications;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Notification as IlluminateNotification;

class NotificationService
{
    /** @var \App\Models\User */
    private $users;

    /**
     * Construct a new ReorderNotificationService.
     *
     * @param  \App\Models\User  $users
     */
    public function __construct(User $users)
    {
        $this->users = $users;
    }

    /**
     * Send a notification.
     *
     * @param  \App\Models\User|\Illuminate\Database\Eloquent\Collection
     * @param  \Illuminate\Notifications\Notification  $notification
     */
    protected function send($recipients, IlluminateNotification $notification): void
    {
        if ($recipients instanceof User) {
            $recipients->notify($notification);
        }

        if ($recipients instanceof Collection) {
            Notification::send($recipients, $notification);
        }
    }
}
