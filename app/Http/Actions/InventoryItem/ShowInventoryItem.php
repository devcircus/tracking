<?php

namespace App\Http\Actions\InventoryItem;

use App\Models\InventoryItem;
use PerfectOblivion\Actions\Action;
use App\Http\Responders\InventoryItem\ShowInventoryItemResponder;

class ShowInventoryItem extends Action
{
    /** @var \App\Http\Responders\InventoryItem\ShowInventoryItemResponder */
    private $responder;

    /**
     * Construct a new ShowInventoryItem action.
     *
     * @param  \App\Http\Responders\InventoryItem\ShowInventoryItemResponder  $responder
     */
    public function __construct(ShowInventoryItemResponder $responder)
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
        return $this->responder->withPayload($item->withInStockCount()->withRecentTags()->withActiveTags())->respond();
    }
}
