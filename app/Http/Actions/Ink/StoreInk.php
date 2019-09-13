<?php

namespace App\Http\Actions\Ink;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Ink\StoreInkService;
use App\Http\Responders\Ink\StoreInkResponder;

class StoreInk extends Action
{
    /** @var \App\Http\Responders\Ink\StoreInkResponder */
    private $responder;

    /**
    * Construct a new StoreInk action.
    *
    * @param  \App\Http\Responders\Ink\StoreInkResponder  $responder
    */
    public function __construct(StoreInkResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $stored = StoreInkService::call($request->only([
            'version', 'type','manufacturer'
        ]));

        return $this->responder->withPayload($stored)->respond();
    }
}
