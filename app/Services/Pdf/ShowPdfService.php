<?php

namespace App\Services\Pdf;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ShowPdfService
{
    use SelfCallingService;

    /** @var \App\Models\Order */
    private $orders;

    /**
     * Construct a new ShowPdfService service.
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
     */
    public function run(array $request, string $type): Collection
    {
        return $this->orders->with('types')->type($type)->forDate($request['date'])->get();
    }
}
