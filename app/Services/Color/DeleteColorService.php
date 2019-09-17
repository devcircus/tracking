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
        $deleted = $printer->deleteColor();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($deleted)
            ->withProperties(['target' => $deleted->name])
            ->log('color deleted');

        return $deleted;
    }
}
