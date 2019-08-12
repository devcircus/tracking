<?php

namespace App\Http\Responders\Tag;

use PerfectOblivion\Responder\Responder;

class ReactivateTagResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function respond()
    {
        $this->request->session()->flash('success', 'Tag successfully reactivated!');

        return redirect()->back(303);
    }
}
