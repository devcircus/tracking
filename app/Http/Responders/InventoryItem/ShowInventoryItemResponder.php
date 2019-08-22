<?php

namespace App\Http\Responders\InventoryItem;

use Inertia\Inertia;
use PerfectOblivion\Responder\Responder;

class ShowInventoryItemResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        return Inertia::render('Items/Show', [
            'item' => $this->payload,
        ]);
    }
}
