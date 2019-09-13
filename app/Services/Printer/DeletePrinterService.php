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
        return $printer->deletePrinter();
    }
}
