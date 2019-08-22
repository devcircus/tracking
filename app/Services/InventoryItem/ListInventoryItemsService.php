<?php

namespace App\Services\Item;

use App\Models\InventoryItem;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ListInventoryItemsService
{
    use SelfCallingService;

    /** @var \App\Models\InventoryItem */
    private $items;

    /**
     * Construct a new ListInventoryItemsService.
     *
     * @param  \App\Models\InventoryItem  $items
     */
    public function __construct(InventoryItem $items)
    {
        $this->items = $items;
    }

    /**
     * Handle the call to the service.
     *
     * @return \Illuminate\Support\Collection
     */
    public function run()
    {
        return $this->items->retrieveAllItems($withTrashed = true);
    }
}
