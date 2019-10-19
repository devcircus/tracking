<?php

namespace App\Http\Responders\Tag;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class RestoreTagResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Tag successfully restored!');

        return redirect()->back(303);
    }
}
