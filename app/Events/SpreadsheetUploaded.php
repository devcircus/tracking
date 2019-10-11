<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SpreadsheetUploaded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var string */
    public $date;

    /** @var \App\Models\User */
    public $user;

    /**
     * The name of the queue on which to place the event.
     *
     * @var string
     */
    public $broadcastQueue = 'orders-broadcast';

    /**
     * Create a new event instance.
     *
     * @param  string  $date
     * @param  \App\Models\User  $user
     */
    public function __construct(string $date, User $user)
    {
        $this->date = $date;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('upload');
    }

    /**
     * Name of the Event to broadcast.
     */
    public function broadcastAs(): string
    {
        return 'uploadComplete';
    }

    /**
     * Get the tags that should be assigned to the job.
     */
    public function tags(): array
    {
        return ['orders', 'uploaded'];
    }
}
