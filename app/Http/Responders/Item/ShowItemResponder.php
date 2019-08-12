<?php

namespace App\Http\Responders\Item;

use Inertia\Inertia;
use PerfectOblivion\Responder\Responder;

class ShowItemResponder extends Responder
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
