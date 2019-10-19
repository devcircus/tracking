<?php

namespace App\Http\Responders\Tag;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class StoreTagResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Tag stored successfully!');

        return redirect()->back();
    }
}
