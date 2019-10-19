<?php

namespace App\Http\Responders\Order;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class BatchUpdateInfoResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Batch update successful.');

        return redirect()->back();
    }
}
