<?php

namespace App\Http\Responders\Order;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class AddOrderResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Voucher successfully added!');

        return redirect()->back();
    }
}
