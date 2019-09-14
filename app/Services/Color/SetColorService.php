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
     *
     * @return mixed
     */
    public function run(Color $color, Printer $printer, array $data)
    {
        $this->validator->validate($data);

        if ($printer->colors->contains($color)) {
            return $printer->colors()->updateExistingPivot($color->id, $data);
        }

        return $printer->colors()->attach($color->id, $data);
    }
}
