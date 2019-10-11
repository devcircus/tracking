<?php

namespace App\Http\Actions\Order;

use App\Models\Order;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Order\DeleteOrderService;
use App\Http\Responders\Order\DeleteOrderResponder;

class DeleteOrder extends Action
{
    /** @var \App\Http\Responders\Order\DeleteOrderResponder */
    private $responder;

    /**
    * Construct a new DeleteOrder action.
    *
    * @param  \App\Http\Responders\Order\DeleteOrderResponder  $responder
    */
    public function __construct(DeleteOrderResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Delete an order.
     *
     * @param  \App\Models\Order  $order
     */
    public function __invoke(Order $order): RedirectResponse
    {
        return $this->responder->withPayload(DeleteOrderService::call($order))->respond();
    }
}
