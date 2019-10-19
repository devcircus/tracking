<?php

namespace App\Http\Responders\Upload;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class StoreUploadResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        flash('success', 'Report generation started.');

        return redirect()->back();
    }
}
