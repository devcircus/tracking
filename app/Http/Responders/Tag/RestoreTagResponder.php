<?php

namespace App\Http\Responders\Tag;

use PerfectOblivion\Responder\Responder;

class RestoreTagResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function respond()
    {
        $this->request->session()->flash('success', 'Tag successfully restored!');

        return redirect()->back(303);
    }
}
