<?php

namespace App\Http\Responders\Fabric;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class StoreFabricResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Fabric added successfully!');

        return redirect()->route('materials.list');
    }
}
