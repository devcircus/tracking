<?php

namespace App\Http\Actions\InventoryItem;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Http\DTO\InventoryItemData;
use Illuminate\Http\RedirectResponse;
use App\Services\Item\StoreInventoryItemService;
use App\Http\Responders\InventoryItem\StoreInventoryItemResponder;

class StoreInventoryItem extends Action
{
    /** @var \App\Http\Responders\InventoryItem\StoreInventoryItemResponder */
    private $responder;

    /**
    * Construct a new StoreInventoryItem action.
    *
    * @param  \App\Http\Responders\InventoryItem\StoreInventoryItemResponder  $responder
    */
    public function __construct(StoreInventoryItemResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $created = StoreInventoryItemService::call(InventoryItemData::fromRequest($request));

        return $this->responder->withPayload($created)->respond();
    }
}
