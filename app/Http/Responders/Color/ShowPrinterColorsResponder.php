<?php

namespace App\Http\Responders\Color;

use Inertia\Inertia;
use Inertia\Response;
use PerfectOblivion\Responder\Responder;

class ShowPrinterColorsResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): Response
    {
        return Inertia::render('Colors/PrinterColors/Index', $this->payload);
    }
}
