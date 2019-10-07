<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Http\DTO\OrderData;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Order\Validation\AddOrderServiceValidation;

class AddOrderService
{
    use SelfCallingService;

    /** @var \App\Models\Order */
    private $orders;

    /** @var \App\Services\Order\Validation\AddOrderServiceValidation */
    private $validator;

    /**
     * Construct a new AddOrderService.
     *
     * @param  \App\Models\Order  $orders
     * @param  \App\Services\Order\Validation\AddOrderServiceValidation  $validator
     */
    public function __construct(Order $orders, AddOrderServiceValidation $validator)
    {
        $this->orders = $orders;
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @param  \App\Http\DTO\OrderData  $order
     *
     * @return mixed
     */
    public function run(OrderData $order)
    {
        $this->validator->validate($order->toArray());
        $order = $this->orders->saveOrder($order->toArray());

        activity()
            ->causedBy(auth()->user())
            ->performedOn($order)
            ->withProperties(['target' => "{$order->order_number}-{$order->voucher}"])
            ->log('added voucher');

        return $order;
    }
}
