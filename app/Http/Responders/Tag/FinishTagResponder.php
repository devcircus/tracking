<?php

namespace App\Http\Responders\Tag;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class FinishTagResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        $this->request->session()->flash('success', 'Tag successfully finished!');

        return redirect()->back(303);
    }
}
