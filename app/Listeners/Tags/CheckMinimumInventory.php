<?php

namespace App\Listeners\Tags;

use App\Events\Tags\TagFinished;
use App\Events\Items\ItemNeedsReordered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Notifications\ReorderNotificationService;

class CheckMinimumInventory implements ShouldQueue
{
    use InteractsWithQueue;

    /** @var string */
    public $queue = 'inventory-notification';

    /**
     * Handle the event.
     *
     * @param  \App\Events\Tags\TagFinished  $event
     */
    public function handle(TagFinished $event): void
    {
        if ($event->tag->item->reachedMinimumInventory()) {
            ReorderNotificationService::call($event->tag->item);
            ItemNeedsReordered::broadcast($event->tag->item);
        }
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
