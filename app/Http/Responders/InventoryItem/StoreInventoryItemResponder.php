<?php

namespace App\Http\Responders\InventoryItem;

use PerfectOblivion\Responder\Responder;

class StoreInventoryItemResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function respond()
    {
        $this->request->session()->flash('success', 'Item created successfully!');

        return redirect()->route('items.show', $this->payload->id);
    }
}
