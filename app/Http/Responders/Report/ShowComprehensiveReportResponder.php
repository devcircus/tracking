<?php

namespace App\Http\Responders\Report;

use Inertia\Inertia;
use PerfectOblivion\Responder\Responder;

class ShowComprehensiveReportResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        return Inertia::render('Reports/Comprehensive/Show', $this->payload);
    }
}
