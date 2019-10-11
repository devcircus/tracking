<?php

namespace App\Http\Actions\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Order\UpdateOrderService;
use App\Http\Responders\Order\UpdateOrderResponder;

class UpdateOrder extends Action
{
    /** @var \App\Http\Responders\Order\UpdateOrderResponder */
    private $responder;

    /**
    * Construct a new UpdateOrder action.
    *
    * @param  \App\Http\Responders\Order\UpdateOrderResponder  $responder
    */
    public function __construct(UpdateOrderResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \App\Models\Order  $order
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Order $order, Request $request): RedirectResponse
    {
        $result = UpdateOrderService::call($order, $request->only(['info']));

        return $this->responder->withPayload($result)->respond();
    }
}
