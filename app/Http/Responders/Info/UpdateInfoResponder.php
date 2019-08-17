<?php

namespace App\Http\Responders\Info;

use PerfectOblivion\Responder\Responder;

class UpdateInfoResponder extends Responder
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
