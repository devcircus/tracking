<?php

namespace App\Services\Order;

use App\Models\Order;
use Illuminate\Support\Collection;
use PerfectOblivion\Services\Traits\SelfCallingService;

class BatchUpdateInfoService
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
     * @param  string  $date
     */
    public function run(array $info, string $date): Collection
    {
        return $this->orders->batchUpdateInfo($info, $date);
    }
}
