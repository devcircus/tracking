<?php

namespace App\Http\Actions\Item;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Item\StoreItemService;
use App\Http\Responders\Item\StoreItemResponder;
use App\Http\DTO\ItemData;

class StoreItem extends Action
{
    /** @var \App\Http\Responders\Item\StoreItemResponder */
    private $responder;

    /**
    * Construct a new StoreItem action.
    *
    * @param  \App\Http\Responders\Item\StoreItemResponder  $responder
    */
    public function __construct(StoreItemResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $created = StoreItemService::call(ItemData::fromRequest($request));

        return $this->responder->withPayload($created)->respond();
    }
}
