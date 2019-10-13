<?php

namespace App\Services\Summary;

use App\Models\Type;
use App\Models\Order;
use Illuminate\Support\Collection;
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
     */
    public function run(string $date): Collection
    {
        return CacheForeverService::call('summary', function() use ($date) {
            return $this->types->whereType(['prototype', 'ninas'])->get()->map(function ($type) use ($date) {
                $query = $this->orders->type($type->type)->forDate($date)->notComplete($type->type);

                return [
                    'summary' => $query->weeklyVouchers(),
                    'total' => $query->count(),
                ];
            });
        }, $date);
    }
}
