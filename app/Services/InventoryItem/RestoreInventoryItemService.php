<?php

namespace App\Services\Item;

use App\Models\InventoryItem;
use PerfectOblivion\Services\Traits\SelfCallingService;

class RestoreInventoryItemService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\InventoryItem  $item
     */
    public function run(InventoryItem $item): InventoryItem
    {
        return $item->RestoreInventoryItem();
    }
}
