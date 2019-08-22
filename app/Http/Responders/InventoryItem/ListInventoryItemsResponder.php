<?php

namespace App\Http\Responders\InventoryItem;

use Inertia\Inertia;
use PerfectOblivion\Responder\Responder;

class ListInventoryItemsResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\View\View
     */
    public function respond()
    {
        return Inertia::render('Items/Index', [
            'items' => $this->payload,
        ]);
    }
}
