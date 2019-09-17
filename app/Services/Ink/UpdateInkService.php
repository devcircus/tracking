<?php

namespace App\Services\Ink;

use App\Models\Ink;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Ink\Validation\UpdateInkValidationService;

class UpdateInkService
{
    use SelfCallingService;

    /** @var \App\Services\Ink\Validation\UpdateInkValidationService */
    private $validator;

    /**
     * Construct a new UpdateInkService.
     *
     * @param  \App\Services\Ink\Validation\UpdateInkValidationService  $validator
     */
    public function __construct(UpdateInkValidationService $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Ink  $ink
     * @param  array  $data
     */
    public function run(Ink $ink, array $data): Ink
    {
        $this->validator->validate(array_merge($data, ['id' => $ink->id]));

        $updated = $ink->updateInk($data);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($updated)
            ->withProperties(['target' => "{$updated->manufacturer}-{$updated->version}-{$updated->type}"])
            ->log('ink updated');

        return $updated;
    }
}
