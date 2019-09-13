<?php

namespace App\Http\Responders\Fabric;

use Inertia\Inertia;
use Inertia\Response;
use PerfectOblivion\Responder\Responder;

class ShowFabricResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): Response
    {
        return Inertia::render('Fabrics/Show', [
            'fabric' => $this->payload,
        ]);
    }
}
