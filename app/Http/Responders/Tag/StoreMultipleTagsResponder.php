<?php

namespace App\Http\Responders\Tag;

use PerfectOblivion\Responder\Responder;

class StoreMultipleTagsResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function respond()
    {
        $this->request->session()->flash('success', 'Tags created successfully!');

        return redirect()->back();
    }
}
