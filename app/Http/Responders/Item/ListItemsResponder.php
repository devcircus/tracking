<?php

namespace App\Http\Responders\Item;

use Inertia\Inertia;
use PerfectOblivion\Responder\Responder;

class ListItemsResponder extends Responder
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
