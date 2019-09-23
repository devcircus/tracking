<?php

namespace App\Services\Color;

use App\Models\Color;
use App\Models\Printer;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Color\Validation\SetColorValidationService;

class SetColorService
{
    use SelfCallingService;

    /** @var \App\Services\Color\Validation\SetColorValidationService */
    private $validator;

    /**
     * Construct a new SetColorService.
     *
     * @param  \App\Services\Color\Validation\SetColorValidationService  $validator
     */
    public function __construct(SetColorValidationService $validator)
    {
        $this->validator = $validator;
    }
    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Color  $color
     * @param  \App\Models\Printer  $printer
     * @param  array  $data
     */
    public function run(Color $color, Printer $printer, array $data): Color
    {
        $this->validator->validate($data);

        $printer->setPrinterColor($color, $data);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($color)
            ->withProperties(['target' => $color->name])
            ->log('color cmyk set');

        return $color;
    }
}
