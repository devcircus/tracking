<?php

namespace App\Http\Actions\InventoryItem;

use Inertia\Response;
use PerfectOblivion\Actions\Action;
use App\Services\Item\ListInventoryItemsService;
use App\Http\Responders\InventoryItem\ListInventoryItemsResponder;

class ListInventoryItems extends Action
{
    /** @var \App\Http\Responders\InventoryItem\ListInventoryItemsResponder */
    private $responder;

    /**
    * Construct a new ListInventoryItems action.
    *
    * @param  \App\Http\Responders\InventoryItem\ListInventoryItemsResponder  $responder
    */
    public function __construct(ListInventoryItemsResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(): Response
    {
        $items = ListInventoryItemsService::call();

        return $this->responder->withPayload($items)->respond();
    }
}
