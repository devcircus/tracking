<?php

namespace App\Services\Printer;

use App\Models\Printer;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Printer\Validation\UpdatePrinterValidationService;

class UpdatePrinterService
{
    use SelfCallingService;

    /** @var \App\Services\Printer\Validation\UpdatePrinterValidationService */
    private $validator;

    /**
     * Construct a new UpdatePrinterService.
     *
     * @param  \App\Services\Printer\Validation\UpdatePrinterValidationService  $validator
     */
    public function __construct(UpdatePrinterValidationService $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @return mixed
     */
    public function run(Printer $printer, array $data)
    {
        $this->validator->validate(array_merge($data, ['id' => $printer->id]));

        return $printer->updatePrinter($data);
    }
}
