<?php

namespace App\Http\Responders\Report;

use Inertia\Inertia;
use Inertia\Response;
use PerfectOblivion\Responder\Responder;

class ShowComprehensiveReportResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): Response
    {
        return Inertia::render('Reports/Comprehensive/Show', $this->payload);
    }
}
