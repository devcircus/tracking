<?php

namespace App\Http\Responders\Ink;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class RestoreInkResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        $this->request->session()->flash('success', 'Ink successfully restored!');

        return redirect()->route('inks.show', $this->payload->id, 303);
    }
}
