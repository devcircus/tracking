<?php

namespace App\Http\Responders\Printer;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class DeletePrinterResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        $this->request->session()->flash('success', 'Printer deleted successfully!');

        return redirect()->route('printers.show', $this->payload->id, 303);
    }
}
