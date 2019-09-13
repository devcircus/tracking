<?php

namespace App\Services\Color;

use App\Models\Color;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Color\Validation\StoreColorValidationService;

class StoreColorService
{
    use SelfCallingService;

    /** @var \App\Models\Color */
    private $colors;

    /** @var \App\Services\Color\Validation\StoreColorValidationService */
    private $validator;

    /**
     * Construct a new StoreColorService.
     *
     * @param  \App\Models\Color  $colors
     * @param  \App\Services\Color\Validation\StoreColorValidationService  $validator
     */
    public function __construct(Color $colors, StoreColorValidationService $validator)
    {
        $this->colors = $colors;
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @param  array  $data
     */
    public function run(array $data): Color
    {
        $this->validator->validate($data);

        return $this->colors->addColor($data);
    }
}
