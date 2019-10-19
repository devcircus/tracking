<?php

namespace App\Http\Responders\InventoryItem;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class UpdateInventoryItemResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Item updated successfully!');

        return redirect()->back(303);
    }
}
