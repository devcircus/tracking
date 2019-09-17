<?php

namespace App\Services\Printer;

use App\Models\Printer;
use PerfectOblivion\Services\Traits\SelfCallingService;

class DeletePrinterService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Printer  $printer
     */
    public function run(Printer $printer): Printer
    {
        $deleted = $printer->deletePrinter();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($deleted)
            ->withProperties(['target' => $deleted->name])
            ->log('printer deleted');

        return $deleted;
    }
}
