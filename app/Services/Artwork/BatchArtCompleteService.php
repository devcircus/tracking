<?php

namespace App\Services\Artwork;

use App\Models\Order;
use App\Services\Artwork\ArtCompleteService;
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
     *
     * @return mixed
     */
    public function run(array $artwork)
    {
        return collect($artwork)->each(function ($item, $key) {
            return ArtCompleteService::call($this->orders->find($key));
        });
    }
}
