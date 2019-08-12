<?php

namespace App\Services\Info;

use App\Models\Order;
use PerfectOblivion\Services\Traits\SelfCallingService;

class UpdateInfoService
{
    use SelfCallingService;

    /** @var \App\Models\Order */
    private $orders;

    /**
     * Construct a new UpdateInfoService.
     *
     * @param  \App\Models\Order
     */
    public function __construct(Order $orders)
    {
        $this->orders = $orders;
    }

    /**
     * Handle the call to the service.
     *
     * @param  array  $info
     *
     * @return mixed
     */
    public function run(array $info)
    {
        return $this->orders->batchUpdateInfo($info);
    }
}
