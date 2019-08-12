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
        return redirect()->back()->with(['status' => 'Batch update successful!']);
    }
}
