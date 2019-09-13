<?php

namespace App\Http\Responders\Fabric;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class UpdateFabricResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        $this->request->session()->flash('success', 'Fabric updated successfully!');

        return redirect()->route('fabrics.show', $this->payload->id, 303);
    }
}
