<?php

namespace App\Http\Responders\Artwork;

use Inertia\Inertia;
use Inertia\Response;
use PerfectOblivion\Responder\Responder;

class ListArtworkVouchersResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): Response
    {
        return Inertia::render('Reports/Artwork/Index', $this->payload);
    }
}
