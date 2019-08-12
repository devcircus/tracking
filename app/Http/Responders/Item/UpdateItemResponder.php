<?php

namespace App\Http\Responders\Item;

use PerfectOblivion\Responder\Responder;

class UpdateItemResponder extends Responder
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
