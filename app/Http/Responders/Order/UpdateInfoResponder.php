<?php

namespace App\Http\Responders\Order;

use PerfectOblivion\Responder\Responder;

class BatchUpdateInfoResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        $this->request->session()->flash('success', 'Batch update successful.');

        return redirect()->back();
    }
}
