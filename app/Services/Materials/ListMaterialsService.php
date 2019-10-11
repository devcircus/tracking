<?php

namespace App\Services\Materials;

use PerfectOblivion\Services\Traits\SelfCallingService;

class ListMaterialsService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     */
    public function run(): array
    {
        $fabrics = ListFabricsService::call();
        $printers = ListPrintersService::call();
        $colors = ListColorsService::call();
        $inks = ListInksService::call();

        return [
            'fabrics' => $fabrics,
            'printers' => $printers,
            'colors' => $colors,
            'inks' => $inks,
        ];
    }
}
