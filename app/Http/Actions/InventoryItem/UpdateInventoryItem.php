<?php

namespace App\Http\Actions\InventoryItem;

use App\Models\InventoryItem;
use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Item\UpdateInventoryItemService;
use App\Http\Responders\InventoryItem\UpdateInventoryItemResponder;
use App\Http\DTO\InventoryItemData;

class UpdateInventoryItem extends Action
{
    /** @var \App\Http\Responders\InventoryItem\UpdateInventoryItemResponder */
    private $responder;

    /**
    * Construct a new UpdateInventoryItem action.
    *
    * @param  \App\Http\Responders\InventoryItem\UpdateInventoryItemResponder  $responder
    */
    public function __construct(UpdateInventoryItemResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InventoryItem  $item
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, InventoryItem $item)
    {
        $updated = UpdateInventoryItemService::call($item, InventoryItemData::fromRequest($request));

        return $this->responder->withPayload($updated)->respond();
    }
}
