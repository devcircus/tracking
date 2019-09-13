<?php

namespace App\Http\Actions\Fabric;

use Inertia\Response;
use App\Models\Fabric;
use PerfectOblivion\Actions\Action;
use App\Http\Responders\Fabric\ShowFabricResponder;

class ShowFabric extends Action
{
    /** @var \App\Http\Responders\Fabric\ShowFabricResponder */
    private $responder;

    /**
    * Construct a new ShowFabric action.
    *
    * @param  \App\Http\Responders\Fabric\ShowFabricResponder  $responder
    */
    public function __construct(ShowFabricResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \App\Models\Fabric  $fabric
     */
    public function __invoke(Fabric $fabric): Response
    {
        return $this->responder->withPayload($fabric)->respond();
    }
}
