<?php

namespace App\Http\Responders\Tag;

use PerfectOblivion\Responder\Responder;

class FinishMultipleTagsResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function respond()
    {
        $this->request->session()->flash('success', 'Tags successfully finished!');

        return redirect()->back(303);
    }
}
