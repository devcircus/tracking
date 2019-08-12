<?php

namespace App\Listeners;

use App\Models\Order;
use App\Events\OrderTypesSet;
use App\Events\SpreadsheetUploaded;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\OrderTypes\SetOrderTypes;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetTypesForOrders implements ShouldQueue
{
    use InteractsWithQueue;

    /** @var string|null */
    public $queue = 'orders';

    /** @var \App\Models\Order */
    private $orders;

    /**
     * Construct a new SetTypesForOrders listener.
     *
     * @param  \App\Models\Order  $orders
     */
    public function __construct(Order $orders)
    {
        $this->orders = $orders;
    }


    /**
     * Handle the event.
     *
     * @param  object  $event
     */
    public function handle(SpreadsheetUploaded $event)
    {
        $orders = $this->orders->forDate($event->date)->get();

        foreach ($orders as $order) {
            SetOrderTypes::call($order);
        }

        OrderTypesSet::broadcast($event->date);
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array
     */
    public function tags()
    {
        return ['orders', 'types'];
    }
}
