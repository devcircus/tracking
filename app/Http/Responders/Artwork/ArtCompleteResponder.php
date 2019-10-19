<?php

namespace App\Http\Responders\Artwork;

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
        flash('success', "Art for this voucher is {$status}");

        return redirect()->back();
    }
}
