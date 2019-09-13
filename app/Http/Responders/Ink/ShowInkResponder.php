<?php

namespace App\Http\Responders\Ink;

use Inertia\Inertia;
use Inertia\Response;
use PerfectOblivion\Responder\Responder;

class ShowInkResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): Response
    {
        return Inertia::render('Inks/Show', [
            'inkData' => $this->payload,
        ]);
    }
}
