<?php

namespace App\Http\Responders\Order;

use PerfectOblivion\Responder\Responder;

class UpdateOrderResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        $this->request->session()->flash('success', 'Voucher updated successfully!');

        return redirect()->back(303);
    }
}
