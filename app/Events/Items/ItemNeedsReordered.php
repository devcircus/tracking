<?php

namespace App\Events\Items;

use App\Models\Item;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ItemNeedsReordered implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var string */
    public $broadcastQueue = 'inventory-broadcast';

    /** @var \App\Models\Item */
    public $item;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Item  $item
     *
     * @return void
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('reorder');
    }

    /**
     * Name of the Event to broadcast.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'itemReorder';
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array
     */
    public function tags()
    {
        return ['inventory', 'reorder:'.$this->item->name];
    }
}
