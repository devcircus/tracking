<?php

namespace App\Http\Actions\Fabric;

use App\Models\Fabric;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Fabric\DeleteFabricService;
use App\Http\Responders\Fabric\DeleteFabricResponder;

class DeleteFabric extends Action
{
    /** @var \App\Http\Responders\Fabric\DeleteFabricResponder */
    private $responder;

    /**
    * Construct a new DeleteFabric action.
    *
    * @param  \App\Http\Responders\Fabric\DeleteFabricResponder  $responder
    */
    public function __construct(DeleteFabricResponder $responder)
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
        $deleted = DeleteFabricService::call($fabric);

        return $this->responder->withPayload($deleted)->respond();
    }
}
