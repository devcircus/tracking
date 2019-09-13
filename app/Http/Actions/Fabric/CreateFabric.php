<?php

namespace App\Http\Actions\Fabric;

use Inertia\Response;
use PerfectOblivion\Actions\Action;
use App\Http\Responders\Fabric\CreateFabricResponder;

class CreateFabric extends Action
{
    /** @var \App\Http\Responders\Fabric\CreateFabricResponder */
    private $responder;

    /**
    * Construct a new CreateFabric action.
    *
    * @param  \App\Http\Responders\Fabric\CreateFabricResponder  $responder
    */
    public function __construct(CreateFabricResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(): Response
    {
        return $this->responder->respond();
    }
}
