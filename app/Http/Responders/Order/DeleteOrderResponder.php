<?php

namespace App\Http\Responders\Order;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class DeleteOrderResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        $this->request->session()->flash('success', 'Voucher successfully deleted!');

        return redirect()->back(303);
    }
}
