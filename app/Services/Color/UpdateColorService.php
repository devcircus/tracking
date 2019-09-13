<?php

namespace App\Services\Color;

use App\Models\Color;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Color\Validation\UpdateColorValidationService;

class UpdateColorService
{
    use SelfCallingService;

    /** @var \App\Services\Color\Validation\UpdateColorValidationService */
    private $validator;

    /**
     * Construct a new UpdateColorService.
     *
     * @param  \App\Services\Color\Validation\UpdateColorValidationService  $validator
     */
    public function __construct(UpdateColorValidationService $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Color  $color
     * @param  array  $data
     */
    public function run(Color $color, array $data): Color
    {
        $this->validator->validate(array_merge($data, ['id' => $color->id]));

        return $color->updateColor($data);
    }
}
