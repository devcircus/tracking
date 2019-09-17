<?php

namespace App\Services\Ink;

use App\Models\Ink;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Ink\Validation\StoreInkValidationService;

class StoreInkService
{
    use SelfCallingService;

    /** @var \App\Models\Ink */
    private $inks;

    /** @var \App\Services\Ink\Validation\StoreInkValidationService */
    private $validator;

    /**
     * Construct a new StoreInkService.
     *
     * @param  \App\Models\Ink  $inks
     * @param  \App\Services\Ink\Validation\StoreInkValidationService  $validator
     */
    public function __construct(Ink $inks, StoreInkValidationService $validator)
    {
        $this->inks = $inks;
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @param  array  $data
     */
    public function run(array $data): Ink
    {
        $this->validator->validate($data);

        $created = $this->inks->addInk($data);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($created)
            ->withProperties(['target' => "{$created->manufacturer}-{$created->version}-{$created->type}"])
            ->log('ink created');

        return $created;
    }
}
