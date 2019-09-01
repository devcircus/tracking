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
        $this->request->session()->flash('success', 'Voucher successfully added!');

        return redirect()->back();
    }
}
