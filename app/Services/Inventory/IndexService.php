<?php

namespace App\Services\Inventory;

use App\Models\Item;
use PerfectOblivion\Services\Traits\SelfCallingService;

class IndexService
{
    use SelfCallingService;

    /** @var \App\Models\Item */
    private $items;

    /**
     * Construct a new IndexService.
     *
     * @param  \App\Models\Item  $items
     */
    public function __construct(Item $items)
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
