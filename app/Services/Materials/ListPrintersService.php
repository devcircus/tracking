<?php

namespace App\Services\Materials;

use App\Models\Printer;
use Illuminate\Database\Eloquent\Collection;
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
     * @param  string|null  $type
     */
    public function run(?string $type = null): Collection
    {
        return $type ? $this->printers->whereHas('ink', function ($query) use ($type) {
            return $query->where('type', $type);
        })->get() : $this->printers->all();
    }
}
