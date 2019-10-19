<?php

namespace App\Http\Responders\Fabric;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class DeleteFabricResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Fabric deleted successfully!');

        return redirect()->route('fabrics.show', $this->payload->id, 303);
    }
}
