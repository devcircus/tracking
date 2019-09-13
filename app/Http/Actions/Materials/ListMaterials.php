<?php

namespace App\Http\Actions\Materials;

use Inertia\Response;
use PerfectOblivion\Actions\Action;
use App\Services\Materials\ListMaterialsService;
use App\Http\Responders\Materials\ListMaterialsResponder;

class ListMaterials extends Action
{
    /** @var \App\Http\Responders\Materials\ListMaterialsResponder */
    private $responder;

    /**
    * Construct a new ListMaterials action.
    *
    * @param  \App\Http\Responders\Materials\ListMaterialsResponder  $responder
    */
    public function __construct(ListMaterialsResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(): Response
    {
        $results = ListMaterialsService::call();

        return $this->responder->withPayload($results)->respond();
    }
}
