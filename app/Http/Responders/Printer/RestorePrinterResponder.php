<?php

namespace App\Http\Responders\Printer;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class RestorePrinterResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Printer successfully restored!');

        return redirect()->route('printers.show', $this->payload->id, 303);
    }
}
