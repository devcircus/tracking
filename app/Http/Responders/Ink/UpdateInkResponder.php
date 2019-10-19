<?php

namespace App\Http\Responders\Ink;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class UpdateInkResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Ink updated successfully!');

        return redirect()->route('inks.show', $this->payload->id, 303);
    }
}
