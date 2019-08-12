<?php

namespace App\Http\Responders\Order;

use PerfectOblivion\Responder\Responder;

class CompleteOrderResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function respond()
    {
        $this->request->session()->flash('success', 'Voucher marked as complete!');

        return redirect()->back();
    }
}
