<?php

namespace App\Http\Responders\User;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class UpdateUserResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'User information updated!');

        return redirect()->back(303);
    }
}
