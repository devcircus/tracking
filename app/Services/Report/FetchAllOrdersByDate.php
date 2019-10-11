<?php

namespace App\Services\Report;

use App\Models\Type;
use App\Models\Order;
use Illuminate\Support\Collection;
use App\Services\Cache\CacheForeverService;
use PerfectOblivion\Services\Traits\SelfCallingService;

class FetchAllOrdersByDate
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
     */
    public function run(string $date): Collection
    {
        return CacheForeverService::call('reports', function() use ($date) {
            return $this->types->all()->keyBy('type')->map(function ($model, $key) use ($date) {
                return $this->orders->with('types')->type($key)->forDate($date)->get();
            });
        }, $date);
    }
}
