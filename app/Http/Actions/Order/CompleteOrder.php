<?php

namespace App\Http\Actions\Order;

use App\Models\Order;
use PerfectOblivion\Actions\Action;
use App\Services\Order\CompleteOrderService;
use App\Http\Responders\Order\CompleteOrderResponder;

class CompleteOrder extends Action
{
    /** @var \App\Http\Responders\Order\CompleteOrderResponder */
    private $responder;

    /**
     * Construct a new CompleteOrder action.
     *
     * @param  \App\Http\Responders\Order\CompleteOrderResponder  $responder
     */
    public function __construct(CompleteOrderResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Mark an order as complete.
     *
     * @param  \App\Models\Order  $order
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Order $order)
    {
        return $this->responder->withPayload(CompleteOrderService::call($order))->respond();
    }
}
