<?php

namespace App\Http\Responders\Ink;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class StoreInkResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Ink added successfully!');

        return redirect()->route('materials.list');
    }
}
