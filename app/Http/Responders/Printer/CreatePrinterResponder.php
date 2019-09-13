<?php

namespace App\Http\Responders\Printer;

use Inertia\Inertia;
use Inertia\Response;
use PerfectOblivion\Responder\Responder;

class CreatePrinterResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): Response
    {
        return Inertia::render('Printers/Create', $this->payload);
    }
}
