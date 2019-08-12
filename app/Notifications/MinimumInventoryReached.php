<?php

namespace App\Notifications;

use App\Models\Item;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MinimumInventoryReached extends Notification
{
    /** @var \App\Models\Item */
    public $item;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Item  $item
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line("Minimum inventory reached for {$this->item->name}")
                    ->line('Contact raw materials to replenish.');
    }
}
