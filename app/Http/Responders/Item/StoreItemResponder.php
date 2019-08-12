<?php

namespace App\Http\Responders\Item;

use PerfectOblivion\Responder\Responder;

class StoreItemResponder extends Responder
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
