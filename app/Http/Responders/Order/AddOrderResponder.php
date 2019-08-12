<?php

namespace App\Http\Responders\Order;

use PerfectOblivion\Responder\Responder;

class AddOrderResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        return redirect()->back()->with(['status' => 'Voucher successfully added!']);
    }
}
