<?php

namespace App\Http\Actions\Item;

use App\Models\Item;
use PerfectOblivion\Actions\Action;
use App\Services\Item\DeleteItemService;
use App\Http\Responders\Item\DeleteItemResponder;

class DeleteItem extends Action
{
    /** @var \App\Http\Responders\Item\DeleteItemResponder */
    private $responder;

    /**
     * Construct a new DeleteItem action.
     *
     * @param  \App\Http\Responders\Item\DeleteItemResponder  $responder
     */
    public function __construct(DeleteItemResponder $responder)
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
        DeleteItemService::call($item);

        return $this->responder->respond();
    }
}
