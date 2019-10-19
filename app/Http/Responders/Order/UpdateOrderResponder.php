<?php

namespace App\Http\Responders\Order;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class UpdateOrderResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Voucher updated successfully!');

        return redirect()->back(303);
    }
}
