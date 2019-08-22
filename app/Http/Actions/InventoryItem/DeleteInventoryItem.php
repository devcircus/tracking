<?php

namespace App\Http\Actions\InventoryItem;

use App\Models\InventoryItem;
use PerfectOblivion\Actions\Action;
use App\Services\Item\DeleteInventoryItemService;
use App\Http\Responders\InventoryItem\DeleteInventoryItemResponder;

class DeleteInventoryItem extends Action
{
    /** @var \App\Http\Responders\InventoryItem\DeleteInventoryItemResponder */
    private $responder;

    /**
     * Construct a new DeleteInventoryItem action.
     *
     * @param  \App\Http\Responders\InventoryItem\DeleteInventoryItemResponder  $responder
     */
    public function __construct(DeleteInventoryItemResponder $responder)
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
        DeleteInventoryItemService::call($item);

        return $this->responder->respond();
    }
}
