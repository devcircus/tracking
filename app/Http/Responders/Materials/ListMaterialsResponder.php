<?php

namespace App\Http\Responders\Materials;

use Inertia\Inertia;
use Inertia\Response;
use PerfectOblivion\Responder\Responder;

class ListMaterialsResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): Response
    {
        return Inertia::render('Materials/Index', $this->payload);
    }
}
