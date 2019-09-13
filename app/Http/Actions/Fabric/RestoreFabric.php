<?php

namespace App\Http\Actions\Fabric;

use App\Models\Fabric;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Fabric\RestoreFabricService;
use App\Http\Responders\Fabric\RestoreFabricResponder;

class RestoreFabric extends Action
{
    /** @var \App\Http\Responders\Fabric\RestoreFabricResponder */
    private $responder;

    /**
    * Construct a new RestoreFabric action.
    *
    * @param  \App\Http\Responders\Fabric\RestoreFabricResponder  $responder
    */
    public function __construct(RestoreFabricResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \App\Models\Fabric  $fabric
     */
    public function __invoke(Fabric $fabric): RedirectResponse
    {
        $restored = RestoreFabricService::call($fabric);

        return $this->responder->withPayload($restored)->respond();
    }
}
