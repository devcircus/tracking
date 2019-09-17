<?php

namespace App\Services\Fabric;

use App\Models\Fabric;
use PerfectOblivion\Services\Traits\SelfCallingService;

class DeleteFabricService
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Fabric  $printer
     */
    public function run(Fabric $printer): Fabric
    {
        $deleted = $printer->deleteFabric();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($deleted)
            ->withProperties(['target' => $deleted->name])
            ->log('fabric deleted');

        return $deleted;
    }
}
