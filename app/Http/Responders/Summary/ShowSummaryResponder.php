<?php

namespace App\Http\Responders\Summary;

use Inertia\Inertia;
use Inertia\Response;
use PerfectOblivion\Responder\Responder;

class ShowSummaryResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): Response
    {
        return Inertia::render('Summary/Show', [
            'summary' => $this->payload,
            'date' => $this->request->date,
            'timestamp' => $this->request->timestamp,
        ]);
    }
}
