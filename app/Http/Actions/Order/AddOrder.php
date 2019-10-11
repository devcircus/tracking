<?php

namespace App\Http\Actions\Order;

use App\Http\DTO\OrderData;
use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use Illuminate\Http\RedirectResponse;
use App\Services\Order\AddOrderService;
use App\Http\Responders\Order\AddOrderResponder;

class AddOrder extends Action
{
    /** @var \App\Http\Responders\Order\AddOrderResponder */
    private $responder;

    /**
     * Construct a new AddOrder action.
     *
     * @param  \App\Http\Responders\Order\AddOrderResponder  $responder
     */
    public function __construct(AddOrderResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $order = AddOrderService::call(OrderData::fromRequest($request));

        return $this->responder->withPayload($order)->respond();
    }
}
