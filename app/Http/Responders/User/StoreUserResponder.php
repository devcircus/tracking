<?php

namespace App\Http\Responders\User;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class StoreUserResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'User successfully created!');

        return redirect()->route('users.list');
    }
}
