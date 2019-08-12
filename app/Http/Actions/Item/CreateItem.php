<?php

namespace App\Http\Actions\Item;

use PerfectOblivion\Actions\Action;
use App\Http\Responders\Item\CreateItemResponder;

class CreateItem extends Action
{
    /** @var \App\Http\Responders\Item\CreateItemResponder */
    private $responder;

    /**
    * Construct a new CreateItem action.
    *
    * @param  \App\Http\Responders\Item\CreateItemResponder  $responder
    */
    public function __construct(CreateItemResponder $responder)
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
        return $this->responder->respond();
    }
}
