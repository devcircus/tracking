<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ArtComplete extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var \App\Models\Order|\Illuminate\Support\Collection */
    public $order;

    /** @var \App\Models\User */
    public $artist;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Order|\Illuminate\Support\Collection  $order
     * @param  \App\Models\User  $artist
     */
    public function __construct($order, User $artist)
    {
        $this->order = $order;
        $this->artist = $artist;
        $this->queue = 'orders-notification';
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
        $mailMessage = (new MailMessage)
                    ->subject('Art complete')
                    ->line("{$this->artist->name} finished the art for: ");

        if ($this->order instanceof Order) {
            $mailMessage->line("{$this->order->customer} - {$this->order->order_number} - {$this->order->voucher}");
        }

        if ($this->order instanceof Collection) {
            foreach ($this->order as $order) {
                $mailMessage->line("{$order->customer} - {$order->order_number} - {$order->voucher}");
            }
        }

        $mailMessage->line('The voucher(s) are ready to print.');

        return $mailMessage;
    }
}
