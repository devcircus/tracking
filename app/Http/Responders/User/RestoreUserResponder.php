<?php

namespace App\Http\Responders\User;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class RestoreUserResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        $this->request->session()->flash('success', 'User restored!');

        return redirect()->back(303);
    }
}
