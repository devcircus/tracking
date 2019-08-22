<?php

namespace App\Http\Actions\InventoryItem;

use App\Models\InventoryItem;
use PerfectOblivion\Actions\Action;
use App\Services\Item\RestoreInventoryItemService;
use App\Http\Responders\InventoryItem\RestoreInventoryItemResponder;

class RestoreInventoryItem extends Action
{
    /** @var \App\Http\Responders\InventoryItem\RestoreInventoryItemResponder */
    private $responder;

    /**
    * Construct a new RestoreInventoryItem action.
    *
    * @param  \App\Http\Responders\InventoryItem\RestoreInventoryItemResponder  $responder
    */
    public function __construct(RestoreInventoryItemResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \App\Models\InventoryItem  $item
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(InventoryItem $item)
    {
        RestoreInventoryItemService::call($item);

        return $this->responder->respond();
    }
}
