<?php

namespace App\Http\Actions\Fabric;

use PerfectOblivion\Actions\Action;
use App\Services\Fabric\ListFabricsPdfService;
use App\Http\Responders\Fabric\ListFabricsPdfResponder;

class ListFabricsPdf extends Action
{
    /** @var \App\Http\Responders\Fabric\ListFabricsPdfResponder */
    private $responder;

    /**
     * Construct a new ListFabricsPdf action.
     *
     * @param  \App\Http\Responders\Fabric\ListFabricsPdfResponder  $responder
     */
    public function __construct(ListFabricsPdfResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke()
    {
        $fabrics = ListFabricsPdfService::call();

        return $this->responder->withPayload([
            'fabrics' => $fabrics,
        ])->respond();
    }
}
