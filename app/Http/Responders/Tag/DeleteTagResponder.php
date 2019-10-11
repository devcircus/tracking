<?php

namespace App\Http\Responders\Tag;

use Illuminate\Http\RedirectResponse;
use PerfectOblivion\Responder\Responder;

class DeleteTagResponder extends Responder
{
    /**
     * Send a response.
     */
    public function respond(): RedirectResponse
    {
        $this->request->session()->flash('success', 'Tag successfully deleted!');

        return redirect()->back(303);
    }
}
