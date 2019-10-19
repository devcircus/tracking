<?php

namespace App\Http\Responders\Artwork;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class BatchArtCompleteResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', "Artwork 'complete' status changed for each voucher.");

        return redirect()->back();
    }
}
