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
        return $ink->deleteInk();
    }
}
