<?php

namespace App\Http\Responders\Upload;

use PerfectOblivion\Responder\Responder;

class StoreUploadResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function respond()
    {
        return redirect()->back()->with(['info' => 'Spreadsheet upload started.']);
    }
}
