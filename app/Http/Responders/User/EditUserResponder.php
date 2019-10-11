<?php

namespace App\Http\Responders\User;

use Inertia\Inertia;
use Inertia\Response;
use PerfectOblivion\Responder\Responder;

class EditUserResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): Response
    {
        return Inertia::render('Users/Edit', [
            'user' => [
                'id' => $this->payload->id,
                'name' => $this->payload->name,
                'email' => $this->payload->email,
                'is_admin' => $this->payload->is_admin,
                'is_artist' => $this->payload->is_artist,
                'deleted_at' => $this->payload->deleted_at,
            ],
        ]);
    }
}
