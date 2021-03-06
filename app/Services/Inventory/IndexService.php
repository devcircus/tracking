<?php

namespace App\Services\Inventory;

use App\Models\InventoryItem;
use PerfectOblivion\Services\Traits\SelfCallingService;

class IndexService
{
    use SelfCallingService;

    /** @var \App\Models\InventoryItem */
    private $items;

    /**
     * Construct a new IndexService.
     *
     * @param  \App\Models\InventoryItem  $items
     */
    public function __construct(InventoryItem $items)
    {
        $this->items = $items;
    }

    /**
     * Handle the call to the service.
     */
    public function run(): array
    {
        return $this->items->needsReordering();
    }
}
