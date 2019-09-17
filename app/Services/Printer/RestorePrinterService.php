<?php

namespace App\Services\Printer;

use App\Models\Printer;
use PerfectOblivion\Services\Traits\SelfCallingService;

class RestorePrinterService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Printer  $printer
     */
    public function run(Printer $printer): Printer
    {
        $restored = $printer->restorePrinter();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($restored)
            ->withProperties(['target' => $restored->name])
            ->log('printer restored');

        return $restored;
    }
}
