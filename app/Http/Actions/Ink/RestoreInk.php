<?php

namespace App\Http\Actions\Ink;

use App\Models\Ink;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Ink\RestoreInkService;
use App\Http\Responders\Ink\RestoreInkResponder;

class RestoreInk extends Action
{
    /** @var \App\Http\Responders\Ink\RestoreInkResponder */
    private $responder;

    /**
    * Construct a new RestoreInk action.
    *
    * @param  \App\Http\Responders\Ink\RestoreInkResponder  $responder
    */
    public function __construct(RestoreInkResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \App\Models\Ink  $ink
     */
    public function __invoke(Ink $ink): RedirectResponse
    {
        $restored = RestoreInkService::call($ink);

        return $this->responder->withPayload($restored)->respond();
    }
}
