<?php

namespace App\Http\Responders\User;

use Inertia\Inertia;
use Inertia\Response;
use PerfectOblivion\Responder\Responder;

class ListUsersResponder extends Responder
{
    /**
     * Send a list of users as a response.
     */
    public function respond(): Response
    {
        return Inertia::render('Users/Index', $this->payload);
    }
}
