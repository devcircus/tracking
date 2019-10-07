<?php

namespace App\Listeners;

use App\Events\SpreadsheetUploaded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Order\SetTypesForOrdersService;
use App\Services\Report\MarkReportsReadyService;
use App\Services\Upload\StoreUploadInDatabaseService;
use App\Services\Order\CopyManuallyAddedOrdersService;

class ProcessNewSpreadsheet implements ShouldQueue
{
    use InteractsWithQueue;

    /** @var string|null */
    public $queue = 'orders';

    /**
     * Handle the event.
     *
     * @param  \App\Events\SpreadsheetUploaded  $event
     */
    public function handle(SpreadsheetUploaded $event): void
    {
        CopyManuallyAddedOrdersService::call($event->date);
        StoreUploadInDatabaseService::call($event->date, $event->user);
        SetTypesForOrdersService::call($event->date);
        MarkReportsReadyService::call($event->date);
    }
}
