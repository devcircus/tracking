<?php

namespace App\Http\Responders\Item;

use PerfectOblivion\Responder\Responder;
use Inertia\Inertia;

class CreateItemResponder extends Responder
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
