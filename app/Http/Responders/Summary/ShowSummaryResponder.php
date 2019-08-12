<?php

namespace App\Http\Responders\Summary;

use Inertia\Inertia;
use PerfectOblivion\Responder\Responder;

class ShowSummaryResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        return Inertia::render('Summary/Show', [
            'summary' => $this->payload,
            'date' => $this->request->date,
            'timestamp' => $this->request->timestamp,
        ]);
    }
}
