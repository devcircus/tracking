<?php

namespace App\Http\Responders\Tag;

use PerfectOblivion\Responder\Responder;

class FinishTagResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function respond()
    {
        $this->request->session()->flash('success', 'Tag successfully finished!');

        return redirect()->back(303);
    }
}
