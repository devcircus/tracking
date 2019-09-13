<?php

namespace App\Http\Responders\Color;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class UpdateColorResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        $this->request->session()->flash('success', 'Color updated successfully!');

        return redirect()->route('colors.show', $this->payload->id, 303);
    }
}
