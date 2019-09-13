<?php

namespace App\Services\Color;

use App\Models\Color;
use PerfectOblivion\Services\Traits\SelfCallingService;

class DeleteColorService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Color  $printer
     */
    public function run(Color $printer): Color
    {
        return $printer->deleteColor();
    }
}
