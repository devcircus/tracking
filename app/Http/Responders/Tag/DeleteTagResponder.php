<?php

namespace App\Http\Responders\Tag;

use PerfectOblivion\Responder\Responder;

class DeleteTagResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function respond()
    {
        $this->request->session()->flash('success', 'Tag successfully deleted!');

        return redirect()->back(303);
    }
}
