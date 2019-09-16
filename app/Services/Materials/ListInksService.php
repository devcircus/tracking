<?php

namespace App\Services\Materials;

use App\Models\Ink;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ListInksService
{
    use SelfCallingService;

    /** @var \App\Models\Ink */
    private $inks;

    /**
     * Construct a new ListInksService.
     *
     * @param  \App\Models\Ink  $inks
     */
    public function __construct(Ink $inks)
    {
        $this->inks = $inks;
    }

    /**
     * Handle the call to the service.
     *
     * @return mixed
     */
    public function run()
    {
        return $this->inks->withTrashed()->get();
    }
}
