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
    private $order;

    /** @var \App\Services\Order\Validation\AddOrderServiceValidation */
    private $validator;

    /**
     * Construct a new AddOrderService.
     *
     * @param  \App\Models\Order  $order
     * @param  \App\Services\Order\Validation\AddOrderServiceValidation  $validator
     */
    public function __construct(Order $order, AddOrderServiceValidation $validator)
    {
        $this->order = $order;
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

        $order = $this->order->saveOrder($order->toArray());

        activity()
            ->causedBy(auth()->user())
            ->performedOn($order)
            ->withProperties(['target' => "{$order->order_number}-{$order->voucher}"])
            ->log('added voucher');

        return $order;
    }
}
