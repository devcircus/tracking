<?php

namespace App\Http\Responders\Tag;

use PerfectOblivion\Responder\Responder;

class StoreTagResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function respond()
    {
        $this->request->session()->flash('success', 'Tag stored successfully!');

        return redirect()->back();
    }
}
