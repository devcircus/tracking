<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Http\DTO\InfoData;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Order\Validation\UpdateOrderServiceValidation;

class UpdateOrderService
{
    use SelfCallingService;

    /** @var \App\Services\Order\Validation\UpdateOrderServiceValidation */
    private $validator;

    /**
     * Construct a new UpdateOrderService.
     *
     * @param  \App\Services\Order\Validation\UpdateOrderServiceValidation  $validator
     */
    public function __construct(UpdateOrderServiceValidation $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Order  $order
     * @param  array  $info
     *
     * @return mixed
     */
    public function run(Order $order, array $info)
    {
        $this->validator->validate($info);

        $updated = $order->updateOrder($info);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($updated)
            ->withProperties(['target' => "{$updated->order_number}-{$updated->voucher}"])
            ->log('voucher updated');

        return $updated;
    }
}
