<?php

namespace App\Services\Color;

use App\Models\Printer;
use App\Services\Cache\CacheForeverService;
use Illuminate\Database\Eloquent\Collection;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ShowPrinterColorsService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Printer  $printer
     */
    public function run(Printer $printer): Collection
    {
        return CacheForeverService::call('printer-colors', function() use ($printer) {
            return $printer->getColors();
        }, $printer->name);
    }
}
