<?php

namespace App\Http\Actions\Item;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use App\Services\Item\ListItemsService;
use App\Http\Responders\Item\ListItemsResponder;

class ListItems extends Action
{
    /** @var \App\Http\Responders\Item\ListItemsResponder */
    private $responder;

    /**
    * Construct a new ListItems action.
    *
    * @param  \App\Http\Responders\Item\ListItemsResponder  $responder
    */
    public function __construct(ListItemsResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $items = ListItemsService::call();

        return $this->responder->withPayload($items)->respond();
    }
}
