<?php

namespace App\Services\Printer;

use App\Models\Printer;
use App\Services\Printer\Validation\StorePrinterValidationService;
use PerfectOblivion\Services\Traits\SelfCallingService;

class StorePrinterService
{
    use SelfCallingService;

    /** @var \App\Models\Printer */
    private $printers;

    /** @var \App\Services\Printer\Validation\StorePrinterValidationService */
    private $validator;

    /**
     * Construct a new StorePrinterService.
     *
     * @param  \App\Models\Printer  $printers
     * @param  \App\Services\Printer\Validation\StorePrinterValidationService  $validator
     */
    public function __construct(Printer $printers, StorePrinterValidationService $validator)
    {
        $this->printers = $printers;
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @param  array  $data
     */
    public function run(array $data): Printer
    {
        $this->validator->validate($data);

        $created = $this->printers->addPrinter($data);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($created)
            ->withProperties(['target' => $created->name])
            ->log('printer created');

        return $created;
    }
}
