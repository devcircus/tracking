<?php

namespace App\Http\Responders\Tag;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class FinishMultipleTagsResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Tags successfully finished!');

        return redirect()->back(303);
    }
}
