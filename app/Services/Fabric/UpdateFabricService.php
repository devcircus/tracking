<?php

namespace App\Services\Fabric;

use App\Models\Fabric;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Fabric\Validation\UpdateFabricValidationService;

class UpdateFabricService
{
    use SelfCallingService;

    /** @var \App\Services\Fabric\Validation\UpdateFabricValidationService */
    private $validator;

    /**
     * Construct a new UpdateFabricService.
     *
     * @param  \App\Services\Fabric\Validation\UpdateFabricValidationService  $validator
     */
    public function __construct(UpdateFabricValidationService $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\Fabric  $fabric
     * @param  array  $data
     */
    public function run(Fabric $fabric, array $data): Fabric
    {
        $this->validator->validate(array_merge($data, ['id' => $fabric->id]));

        return $fabric->updateFabric($data);
    }
}
