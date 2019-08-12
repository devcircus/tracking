<?php

namespace App\Http\Actions\Item;

use App\Models\Item;
use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Item\UpdateItemService;
use App\Http\Responders\Item\UpdateItemResponder;
use App\Http\DTO\ItemData;

class UpdateItem extends Action
{
    /** @var \App\Http\Responders\Item\UpdateItemResponder */
    private $responder;

    /**
    * Construct a new UpdateItem action.
    *
    * @param  \App\Http\Responders\Item\UpdateItemResponder  $responder
    */
    public function __construct(UpdateItemResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Item $item)
    {
        $updated = UpdateItemService::call($item, ItemData::fromRequest($request));

        return $this->responder->withPayload($updated)->respond();
    }
}
