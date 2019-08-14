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
        $this->request->session()->flash('success', 'Spreadsheet upload started.');

        return redirect()->back();
    }
}
