<?php

namespace App\Http\Actions\Order;

use Inertia\Response;
use PerfectOblivion\Actions\Action;
use App\Services\Order\IndexService;
use App\Http\Responders\Order\IndexResponder;

class Index extends Action
{
    /** @var \App\Http\Responders\Order\IndexResponder */
    private $responder;

    /**
    * Construct a new Orders Index action.
    *
    * @param  \App\Http\Responders\Order\IndexResponder  $responder
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
        $data = IndexService::call();

        return $this->responder->withPayload($data)->respond();
    }
}
