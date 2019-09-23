<?php

namespace App\Services\Summary;

use App\Models\Type;
use App\Models\Order;
use App\Services\Cache\CacheForeverService;
use PerfectOblivion\Services\Traits\SelfCallingService;

class FetchSummaryByDate
{
    use SelfCallingService;

    /** @var \App\Models\Order */
    private $orders;

    /** @var \App\Models\Type */
    private $types;

    /**
     * Construct a new FetchAllOrdersByDate service.
     *
     * @param  \App\Models\Order  $orders
     * @param  \App\Models\Type  $types
     */
    public function __construct(Order $orders, Type $types)
    {
        $this->orders = $orders;
        $this->types = $types;
    }

    /**
     * Handle fetching all reports by the given date.
     *
     * @param  string  $date
     *
     * @return \Illuminate\Support\Collection
     */
    public function run(string $date)
    {
        return CacheForeverService::call('summary', function() use ($date) {
            return $this->types->all()->keyBy('type')->toBase()->only(['prototype', 'ninas'])->map(function ($model, $key) use ($date) {
                $query = $this->orders->type($key)->forDate($date)->notComplete($key);

                return [
                    'summary' => $query->weeklyVouchers(),
                    'total' => $query->count(),
                ];
            });
        }, $date);
    }
}
