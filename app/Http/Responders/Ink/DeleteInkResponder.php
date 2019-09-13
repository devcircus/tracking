<?php

namespace App\Http\Responders\Ink;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class DeleteInkResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        $this->request->session()->flash('success', 'Ink deleted successfully!');

        return redirect()->route('inks.show', $this->payload->id, 303);
    }
}
