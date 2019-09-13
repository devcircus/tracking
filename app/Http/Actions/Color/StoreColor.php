<?php

namespace App\Http\Actions\Color;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Color\StoreColorService;
use App\Http\Responders\Color\StoreColorResponder;

class StoreColor extends Action
{
    /** @var \App\Http\Responders\Color\StoreColorResponder */
    private $responder;

    /**
    * Construct a new StoreColor action.
    *
    * @param  \App\Http\Responders\Color\StoreColorResponder  $responder
    */
    public function __construct(StoreColorResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $stored = StoreColorService::call($request->only([
            'code', 'name','type'
        ]));

        return $this->responder->withPayload($stored)->respond();
    }
}
