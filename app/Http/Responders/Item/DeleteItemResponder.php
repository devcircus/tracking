<?php

namespace App\Http\Responders\Item;

use PerfectOblivion\Responder\Responder;

class DeleteItemResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function respond()
    {
        $this->request->session()->flash('success', 'Item successfully deleted!');

        return redirect()->back(303);
    }
}
