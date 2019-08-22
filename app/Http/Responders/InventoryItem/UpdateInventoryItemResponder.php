<?php

namespace App\Http\Responders\InventoryItem;

use PerfectOblivion\Responder\Responder;

class UpdateInventoryItemResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function respond()
    {
        $this->request->session()->flash('success', 'Item updated successfully!');

        return redirect()->back(303);
    }
}
