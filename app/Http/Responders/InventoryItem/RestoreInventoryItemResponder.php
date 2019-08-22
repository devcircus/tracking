<?php

namespace App\Http\Responders\InventoryItem;

use PerfectOblivion\Responder\Responder;

class RestoreInventoryItemResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function respond()
    {
        $this->request->session()->flash('success', 'Item successfully restored!');

        return redirect()->back(303);
    }
}
