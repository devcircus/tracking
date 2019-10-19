<?php

namespace App\Http\Responders\Fabric;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class RestoreFabricResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Fabric successfully restored!');

        return redirect()->route('fabrics.show', $this->payload->id, 303);
    }
}
