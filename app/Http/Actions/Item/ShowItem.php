<?php

namespace App\Http\Actions\Item;

use App\Models\Item;
use PerfectOblivion\Actions\Action;
use App\Http\Responders\Item\ShowItemResponder;

class ShowItem extends Action
{
    /** @var \App\Http\Responders\Item\ShowItemResponder */
    private $responder;

    /**
     * Construct a new ShowItem action.
     *
     * @param  \App\Http\Responders\Item\ShowItemResponder  $responder
     */
    public function __construct(ShowItemResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \App\Models\Item  $item
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Item $item)
    {
        return $this->responder->withPayload($item->withInStockCount()->withRecentTags()->withActiveTags())->respond();
    }
}
