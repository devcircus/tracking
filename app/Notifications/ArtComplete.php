<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ArtComplete extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var \App\Models\Order */
    public $order;

    /** @var \App\Models\User */
    public $artist;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Order  $order
     * @param  \App\Models\User  $artist
     */
    public function __construct(Order $order, User $artist)
    {
        $this->order = $order;
        $this->artist = $artist;
        $this->queue = 'orders-notification';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
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
                    ->subject("Art complete: {$this->order->customer} - {$this->order->order_number} - {$this->order->voucher}.")
                    ->line("{$this->artist->name} finished the art for: ")
                    ->line("{$this->order->customer} - {$this->order->order_number} - {$this->order->voucher}")
                    ->line('The voucher is ready to print.');
    }
}
