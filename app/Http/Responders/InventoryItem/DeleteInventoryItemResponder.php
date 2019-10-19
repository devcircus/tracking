<?php

namespace App\Http\Responders\InventoryItem;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class DeleteInventoryItemResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Item successfully deleted!');

        return redirect()->back(303);
    }
}
