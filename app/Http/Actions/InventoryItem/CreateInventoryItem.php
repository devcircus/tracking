<?php

namespace App\Http\Actions\InventoryItem;

use Inertia\Response;
use PerfectOblivion\Actions\Action;
use App\Http\Responders\InventoryItem\CreateInventoryItemResponder;

class CreateInventoryItem extends Action
{
    /** @var \App\Http\Responders\InventoryItem\CreateInventoryItemResponder */
    private $responder;

    /**
    * Construct a new CreateInventoryItem action.
    *
    * @param  \App\Http\Responders\InventoryItem\CreateInventoryItemResponder  $responder
    */
    public function __construct(CreateInventoryItemResponder $responder)
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
