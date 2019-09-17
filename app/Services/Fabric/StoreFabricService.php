<?php

namespace App\Services\Fabric;

use App\Models\Fabric;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Fabric\Validation\StoreFabricValidationService;

class StoreFabricService
{
    use SelfCallingService;

    /** @var \App\Models\Fabric */
    private $fabrics;

    /** @var \App\Services\Fabric\Validation\StoreFabricValidationService */
    private $validator;

    /**
     * Construct a new StoreFabricService.
     *
     * @param  \App\Models\Fabric  $fabrics
     * @param  \App\Services\Fabric\Validation\StoreFabricValidationService  $validator
     */
    public function __construct(Fabric $fabrics, StoreFabricValidationService $validator)
    {
        $this->fabrics = $fabrics;
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @param  array  $data
     */
    public function run(array $data): Fabric
    {
        $this->validator->validate($data);

        $created = $this->fabrics->addFabric($data);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($created)
            ->withProperties(['target' => $created->name])
            ->log('fabric created');

        return $created;
    }
}
