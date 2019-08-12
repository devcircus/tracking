<?php

namespace App\Http\Actions\Item;

use App\Models\Item;
use PerfectOblivion\Actions\Action;
use App\Services\Item\RestoreItemService;
use App\Http\Responders\Item\RestoreItemResponder;

class RestoreItem extends Action
{
    /** @var \App\Http\Responders\Item\RestoreItemResponder */
    private $responder;

    /**
    * Construct a new RestoreItem action.
    *
    * @param  \App\Http\Responders\Item\RestoreItemResponder  $responder
    */
    public function __construct(RestoreItemResponder $responder)
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
        RestoreItemService::call($item);

        return $this->responder->respond();
    }
}
