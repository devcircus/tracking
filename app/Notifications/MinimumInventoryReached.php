<?php

namespace App\Notifications;

use App\Models\InventoryItem;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MinimumInventoryReached extends Notification
{
    /** @var \App\Models\InventoryItem */
    public $item;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\InventoryItem  $item
     */
    public function __construct(InventoryItem $item)
    {
        $this->item = $item;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line("Minimum inventory reached for {$this->item->name}")
                    ->line('Contact raw materials to replenish.');
    }
}
