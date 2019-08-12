<?php

namespace App\Http\Actions\Inventory;

use Inertia\Response;
use PerfectOblivion\Actions\Action;
use App\Http\Responders\Inventory\IndexResponder;

class Index extends Action
{
    /** @var \App\Http\Responders\Inventory\IndexResponder */
    private $responder;

    /**
    * Construct a new Inventory Index action.
    *
    * @param  \App\Http\Responders\Inventory\IndexResponder  $responder
    */
    public function __construct(IndexResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(): Response
    {
        return $this->responder->respond();
    }
}
