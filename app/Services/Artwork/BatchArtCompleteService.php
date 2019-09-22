<?php

namespace App\Services\Artwork;

use App\Models\Order;
use Illuminate\Support\Collection;
use PerfectOblivion\Services\Traits\SelfCallingService;

class BatchArtCompleteService
{
    use SelfCallingService;

    /** @var \App\Models\Order */
    private $orders;

    /**
     * Construct a new BatchArtCompleteService.
     *
     * @param  \App\Models\Order  $orders
     */
    public function __construct(Order $orders)
    {
        $this->orders = $orders;
    }

    /**
     * Handle the call to the service.
     *
     * @param  array  $artwork
     */
    public function run(array $artwork): array
    {
        $orders = collect($artwork)->map(function ($item, $key) {
            return $this->orders->find($key);
        });

        $completed = [];
        foreach ($orders as $order) {
            if (ArtCompleteService::call($order)) {
                $completed[] = $order;
            }
        }

        return $completed;
    }
}
