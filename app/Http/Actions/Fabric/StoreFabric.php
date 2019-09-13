<?php

namespace App\Http\Actions\Fabric;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Fabric\StoreFabricService;
use App\Http\Responders\Fabric\StoreFabricResponder;

class StoreFabric extends Action
{
    /** @var \App\Http\Responders\Fabric\StoreFabricResponder */
    private $responder;

    /**
    * Construct a new StoreFabric action.
    *
    * @param  \App\Http\Responders\Fabric\StoreFabricResponder  $responder
    */
    public function __construct(StoreFabricResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $stored = StoreFabricService::call($request->only([
            'code', 'name','manufacturer', 'cross_grain', 'press_speed'
        ]));

        return $this->responder->withPayload($stored)->respond();
    }
}
