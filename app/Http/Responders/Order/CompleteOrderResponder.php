<?php

namespace App\Http\Responders\Order;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class CompleteOrderResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Voucher marked as complete!');

        return redirect()->back();
    }
}
