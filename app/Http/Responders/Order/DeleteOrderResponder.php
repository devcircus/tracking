<?php

namespace App\Http\Responders\Order;

use PerfectOblivion\Responder\Responder;

class DeleteOrderResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function respond()
    {
        $this->request->session()->flash('success', 'Voucher successfully deleted!');

        return redirect()->back(303);
    }
}
