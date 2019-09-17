<?php

namespace App\Services\Ink;

use App\Models\Ink;
use PerfectOblivion\Services\Traits\SelfCallingService;

class DeleteInkService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Ink  $ink
     */
    public function run(Ink $ink): Ink
    {
        $deleted = $ink->deleteInk();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($deleted)
            ->withProperties(['target' => "{$deleted->manufacturer}-{$deleted->version}-{$deleted->type}"])
            ->log('ink deleted');

        return $deleted;
    }
}
