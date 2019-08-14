<?php

namespace App\Listeners;

use App\Models\Upload;
use App\Events\OrderTypesSet;

class ReportsReady
{
    /** @var \App\Models\Upload */
    private $uploads;

    /**
     * Create the event listener.
     *
     * @param  \App\Models\Upload  $uploads
     */
    public function __construct(Upload $uploads)
    {
        $this->uploads = $uploads;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderTypesSet  $event
     */
    public function handle(OrderTypesSet $event)
    {
        $this->uploads->reportsReady($event->date);
    }
}
