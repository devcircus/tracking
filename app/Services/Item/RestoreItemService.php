<?php

namespace App\Services\Item;

use App\Models\Item;
use PerfectOblivion\Services\Traits\SelfCallingService;

class RestoreItemService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Item  $item
     */
    public function run(Item $item): Item
    {
        return $item->restoreItem();
    }
}
