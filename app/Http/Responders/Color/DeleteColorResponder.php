<?php

namespace App\Http\Responders\Color;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class DeleteColorResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Color deleted successfully!');

        return redirect()->route('colors.show', $this->payload->id, 303);
    }
}
