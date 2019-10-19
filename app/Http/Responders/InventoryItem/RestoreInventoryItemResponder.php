<?php

namespace App\Http\Responders\InventoryItem;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class RestoreInventoryItemResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Item successfully restored!');

        return redirect()->back(303);
    }
}
