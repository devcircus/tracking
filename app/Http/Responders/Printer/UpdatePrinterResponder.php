<?php

namespace App\Http\Responders\Printer;

use PerfectOblivion\Responder\Responder;

class UpdatePrinterResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        $this->request->session()->flash('success', 'Printer updated successfully!');

        return redirect()->route('printers.show', $this->payload->id, 303);
    }
}
