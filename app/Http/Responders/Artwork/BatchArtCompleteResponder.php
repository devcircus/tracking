<?php

namespace App\Http\Responders\Artwork;

use PerfectOblivion\Responder\Responder;

class BatchArtCompleteResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function respond()
    {
        $this->request->session()->flash('success', "Artwork 'complete' status changed for each voucher.");

        return redirect()->back();
    }
}
