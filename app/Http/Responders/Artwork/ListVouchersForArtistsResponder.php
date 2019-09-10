<?php

namespace App\Http\Responders\Artwork;

use Inertia\Inertia;
use Inertia\Response;
use PerfectOblivion\Responder\Responder;

class ListVouchersForArtistsResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): Response
    {
        return Inertia::render('Reports/Artwork/Index', [
            'results' => $this->payload['reports'],
            'date' => $this->payload['date'],
            'timestamp' => $this->payload['timestamp'],
        ]);
    }
}
