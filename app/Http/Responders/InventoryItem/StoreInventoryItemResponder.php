<?php

namespace App\Http\Responders\InventoryItem;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class StoreInventoryItemResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Item created successfully!');

        return redirect()->route('items.show', $this->payload->id);
    }
}
