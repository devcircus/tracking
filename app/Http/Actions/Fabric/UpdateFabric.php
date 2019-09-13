<?php

namespace App\Http\Actions\Fabric;

use App\Models\Fabric;
use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Fabric\UpdateFabricService;
use App\Http\Responders\Fabric\UpdateFabricResponder;

class UpdateFabric extends Action
{
    /** @var \App\Http\Responders\Fabric\UpdateFabricResponder */
    private $responder;

    /**
     * Construct a new UpdateFabric action.
     *
     * @param  \App\Http\Responders\Fabric\UpdateFabricResponder  $responder
     */
    public function __construct(UpdateFabricResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fabric  $fabric
     */
    public function __invoke(Request $request, Fabric $fabric): RedirectResponse
    {
        $updated = UpdateFabricService::call($fabric, $request->only([
            'code', 'name', 'manufacturer', 'cross_grain', 'press_speed'
        ]));

        return $this->responder->withPayload($updated)->respond();
    }
}
