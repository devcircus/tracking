<?php

namespace App\Services\Materials;

use App\Models\Printer;
use PerfectOblivion\Services\Traits\SelfCallingService;

class ListPrintersService
{
    use SelfCallingService;

    /** @var \App\Models\Printer */
    private $printers;

    /**
     * Construct a new ListPrintersService.
     *
     * @param  \App\Models\Printer  $printers
     */
    public function __construct(Printer $printers)
    {
        $this->printers = $printers;
    }

    /**
     * Handle the call to the service.
     *
     * @return mixed
     */
    public function run()
    {
        return $this->printers->all();
    }
}
