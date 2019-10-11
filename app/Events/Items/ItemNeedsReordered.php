<?php

namespace App\Events\InventoryItems;

use App\Models\InventoryItem;
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

    /** @var \App\Models\InventoryItem */
    public $item;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\InventoryItem  $item
     */
    public function __construct(InventoryItem $item)
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
     */
    public function broadcastAs(): string
    {
        return 'itemReorder';
    }

    /**
     * Get the tags that should be assigned to the job.
     */
    public function tags(): array
    {
        return ['inventory', 'reorder:'.$this->item->name];
    }
}
