<?php

namespace App\Http\Responders\Printer;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class StorePrinterResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        $this->request->session()->flash('success', 'Printer added successfully!');

        return redirect()->route('materials.list');
    }
}
