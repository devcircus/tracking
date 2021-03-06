<?php

namespace App\Http\Responders\User;

use Inertia\Inertia;
use Inertia\Response;
use PerfectOblivion\Responder\Responder;

class CreateUserResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): Response
    {
        return Inertia::render('Users/Create');
    }
}
