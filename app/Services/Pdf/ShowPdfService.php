<?php

namespace App\Services\Pdf;

use App\Models\Order;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ShowPdfService
{
    use SelfCallingService;

    /** @var \App\Models\Order */
    private $orders;

    /**
     * Construct a new FetchAllOrdersByDate service.
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
     * @param  array  $request
     * @param  string  $type
     *
     * @return mixed
     */
    public function run(array $request, string $type)
    {
        return $this->orders->with('types')->type($type)->forDate($request['date'])->get();
    }
}
