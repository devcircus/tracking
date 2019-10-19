<?php

namespace App\Http\Responders\Color;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class StoreColorResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Color added successfully!');

        return redirect()->route('materials.list');
    }
}
