<?php

namespace App\Services\Fabric;

use App\Models\Fabric;
use PerfectOblivion\Services\Traits\SelfCallingService;

class RestoreFabricService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Fabric  $printer
     */
    public function run(Fabric $printer): Fabric
    {
        $restored = $printer->restoreFabric();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($restored)
            ->withProperties(['target' => $restored->name])
            ->log('fabric restored');

        return $restored;
    }
}
