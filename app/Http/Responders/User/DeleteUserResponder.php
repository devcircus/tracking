<?php

namespace App\Http\Responders\User;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class DeleteUserResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'User deleted!');

        return redirect()->back(303);
    }
}
