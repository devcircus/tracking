<?php

namespace App\Http\Responders\User;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class UpdateUserResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond(): RedirectResponse
    {
        $this->request->session()->flash('success', 'User information updated!');

        return redirect()->back(303);
    }
}
