<?php

namespace App\Http\Responders\InventoryItem;

use Inertia\Inertia;
use Inertia\Response;
use PerfectOblivion\Responder\Responder;

class CreateInventoryItemResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): Response
    {
        return Inertia::render('Items/Create');
    }
}
