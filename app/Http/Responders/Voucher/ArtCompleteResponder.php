<?php

namespace App\Http\Responders\Voucher;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class ArtCompleteResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        $status = $this->payload ? 'complete' : 'not complete';
        $this->request->session()->flash('success', "Art for this voucher is {$status}");

        return redirect()->back();
    }
}
