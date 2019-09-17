<?php

namespace App\Services\Ink;

use App\Models\Ink;
use PerfectOblivion\Services\Traits\SelfCallingService;

class RestoreInkService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Ink  $ink
     */
    public function run(Ink $ink): Ink
    {
        $restored = $ink->restoreInk();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($restored)
            ->withProperties(['target' => "{$restored->manufacturer}-{$restored->version}-{$restored->type}"])
            ->log('ink restored');

        return $restored;
    }
}
