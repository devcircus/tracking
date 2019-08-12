<?php

namespace App\Services\Item;

use App\Models\Item;
use Illuminate\Database\Eloquent\Builder;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ListItemsService
{
    use SelfCallingService;

    /** @var \App\Models\Item */
    private $items;

    /**
     * Construct a new ListItemsService.
     *
     * @param  \App\Models\Item  $items
     */
    public function __construct(Item $items)
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
