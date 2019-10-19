<?php

namespace App\Http\Responders\Color;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class SetColorResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Color values successfully set!');

        return redirect()->back();
    }
}
