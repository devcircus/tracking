<?php

namespace App\Http\Responders\InventoryItem;

use Inertia\Inertia;
use PerfectOblivion\Responder\Responder;

class CreateInventoryItemResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\View\View
     */
    public function respond()
    {
        return Inertia::render('Items/Create');
    }
}
